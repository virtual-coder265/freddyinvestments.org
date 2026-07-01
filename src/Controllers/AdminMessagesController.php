<?php
namespace App\Controllers;

use App\Controllers\Admin\AdminController;
use App\Models\AuditLog;
use App\Models\Message;
use App\Database\Database;

/**
 * Admin Messages Controller
 */
class AdminMessagesController extends AdminController {
    protected $currentPage = 'messages';

    public function index() {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $perPage = 20;
        $search = sanitize($_GET['q'] ?? '');
        $offset = ($page - 1) * $perPage;

        $where = '1=1';
        $params = [];
        if ($search !== '') {
            $where .= ' AND (name LIKE ? OR email LIKE ? OR message LIKE ?)';
            $like = '%' . $search . '%';
            $params = [$like, $like, $like];
        }

        $db = Database::getInstance();
        $total = (int) $db->fetch("SELECT COUNT(*) as count FROM messages WHERE {$where}", $params)['count'];
        $rows = $db->fetchAll(
            "SELECT * FROM messages WHERE {$where} ORDER BY created_at DESC LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );

        $messages = [];
        foreach ($rows as $row) {
            $item = new Message();
            $item->attributes = $row;
            $messages[] = $item;
        }

        $unread_count = Message::count("status = ?", ['unread']);
        
        $this->render('messages/index', [
            'title' => 'Messages | Admin Panel',
            'messages' => $messages,
            'unread_count' => $unread_count,
            'page' => $page,
            'totalPages' => max(1, (int) ceil($total / $perPage)),
            'search' => $search,
            'breadcrumbs' => [
                ['label' => 'Settings & Tools', 'url' => url('admin/settings')],
                ['label' => 'Messages'],
            ],
        ]);
    }

    public function view($id) {
        $message = Message::find($id);
        if (!$message) {
            $this->redirect('admin/messages', 'Message not found.', 'error');
        }

        if ($message['status'] === 'unread') {
            Database::getInstance()->update(
                'messages',
                ['status' => 'read', 'updated_at' => date('Y-m-d H:i:s')],
                'id = ?',
                [$id]
            );
        }

        $this->render('messages/view', [
            'title' => 'View Message | Admin Panel',
            'message' => $message,
            'breadcrumbs' => [
                ['label' => 'Messages', 'url' => url('admin/messages')],
                ['label' => 'View Message'],
            ],
        ]);
    }

    public function reply() {
        $this->requirePost();
        $this->validateCsrfOrRedirect('admin/messages');

        $message_id = intval($_POST['message_id'] ?? 0);
        $response = sanitize($_POST['response'] ?? '');

        $message = Message::find($message_id);
        if (!$message) {
            $this->redirect('admin/messages', 'Message not found.', 'error');
        }

        if (empty($response)) {
            $this->redirect("admin/messages/{$message_id}/view", 'Response text is required.', 'error');
        }

        Database::getInstance()->update(
            'messages',
            [
                'response' => $response,
                'responded_by' => \App\Auth\AuthManager::id(),
                'status' => 'replied',
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            'id = ?',
            [$message_id]
        );
        AuditLog::record('reply', 'message', $message_id);

        $fromEmail = cms_setting('company_email', 'noreply@freddyinvestments.org');
        $siteName = cms_setting('site_name', 'Freddy Investments');
        $subject = 'Re: Your message to ' . $siteName;
        $headers = "From: {$siteName} <{$fromEmail}>\r\nReply-To: {$fromEmail}\r\nContent-Type: text/plain; charset=UTF-8\r\n";
        @mail($message['email'], $subject, $response, $headers);

        $this->redirect('admin/messages', 'Reply saved and email sent if mail server is configured.');
    }

    public function delete($id) {
        $this->requirePost();
        $this->validateCsrfOrRedirect('admin/messages');

        $message = Message::find($id);
        if (!$message) {
            $this->redirect('admin/messages', 'Message not found.', 'error');
        }

        $message->delete();
        AuditLog::record('delete', 'message', $id);
        $this->redirect('admin/messages', 'Message deleted successfully.');
    }
}
