<?php
namespace App;

/**
 * Freddy Investments Custom Secure Router
 */
class Router {
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Register a GET route
     */
    public function get($route, $handler) {
        $this->routes['GET'][$this->normalize($route)] = $handler;
    }

    /**
     * Register a POST route
     */
    public function post($route, $handler) {
        $this->routes['POST'][$this->normalize($route)] = $handler;
    }

    /**
     * Normalize paths by trimming slashes
     */
    protected function normalize($path) {
        return trim($path, '/');
    }

    /**
     * Resolve the route request
     */
    public function resolve($path) {
        $method = $_SERVER['REQUEST_METHOD'];
        $normalizedPath = $this->normalize($path);

        // Strip query string from path for routing matching (e.g. contact?msg=success -> contact)
        if (strpos($normalizedPath, '?') !== false) {
            $normalizedPath = explode('?', $normalizedPath)[0];
            $normalizedPath = $this->normalize($normalizedPath);
        }

        // Check for exact match first
        if (isset($this->routes[$method][$normalizedPath])) {
            $handler = $this->routes[$method][$normalizedPath];
            $this->executeHandler($handler);
            return;
        }

        // Try to match parameterized routes
        $pathParts = explode('/', $normalizedPath);
        foreach ($this->routes[$method] as $routePattern => $handler) {
            $routeParts = explode('/', $routePattern);
            
            if (count($routeParts) === count($pathParts)) {
                $match = true;
                $params = [];
                
                foreach ($routeParts as $index => $part) {
                    if (strpos($part, '{') === 0 && strpos($part, '}') === strlen($part) - 1) {
                        // This is a parameter
                        $paramName = substr($part, 1, -1);
                        $params[$paramName] = $pathParts[$index];
                    } elseif ($part !== $pathParts[$index]) {
                        $match = false;
                        break;
                    }
                }
                
                if ($match) {
                    $this->executeHandler($handler, $params);
                    return;
                }
            }
        }

        // Handle 404 Not Found Page
        $this->handleNotFound();
    }

    /**
     * Instantiate controller and execute action method
     */
    protected function executeHandler($handler, $params = []) {
        if (is_callable($handler)) {
            call_user_func($handler, ...$params);
            return;
        }

        if (is_string($handler) && strpos($handler, '@') !== false) {
            list($controllerName, $action) = explode('@', $handler);
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $action)) {
                    call_user_func_array([$controller, $action], array_values($params));
                    return;
                }
            }
        }

        $this->handleNotFound();
    }

    /**
     * Safely render 404 error page
     */
    protected function handleNotFound() {
        http_response_code(404);
        
        $title = "Page Not Found | Freddy Investments";
        
        // Render header
        if (file_exists(__DIR__ . '/Views/layout/header.php')) {
            require_once __DIR__ . '/Views/layout/header.php';
        }
        
        // Render 404 View directly
        ?>
        <div class="min-h-[70vh] flex items-center justify-center bg-slate-950 text-white px-6">
            <div class="text-center max-w-md">
                <span class="text-emerald-500 font-mono text-lg tracking-widest uppercase block mb-2">Error 404</span>
                <h1 class="text-4xl sm:text-5xl font-extrabold font-display mb-4 text-slate-100">Page Not Found</h1>
                <p class="text-slate-400 mb-8 leading-relaxed">
                    The page you are looking for might have been removed, had its name changed, or is temporarily unavailable. Let's get you back on track.
                </p>
                <a href="<?php echo url(); ?>" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-slate-950 bg-emerald-400 hover:bg-emerald-300 shadow-lg shadow-emerald-500/20 transform hover:-translate-y-0.5 transition-all duration-200">
                    <!-- Home Icon SVG -->
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Return to Homepage
                </a>
            </div>
        </div>
        <?php
        
        // Render footer
        if (file_exists(__DIR__ . '/Views/layout/footer.php')) {
            require_once __DIR__ . '/Views/layout/footer.php';
        }
    }
}
