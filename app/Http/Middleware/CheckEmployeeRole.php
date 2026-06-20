<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmployeeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles (Danh sách các quyền yêu cầu)
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Nếu là Chủ doanh nghiệp (đăng nhập bằng guard 'web'), luôn cho phép qua
        if (auth('web')->check()) {
            return $next($request);
        }

        // 2. Nếu là Nhân viên (đăng nhập bằng guard 'employee')
        if (auth('employee')->check()) {
            $employee = auth('employee')->user();
            // Lấy danh sách quyền của nhân viên, nếu null thì gán mảng rỗng
            $employeeRoles = $employee->roles ?? [];

            // Kiểm tra xem nhân viên có ít nhất 1 quyền khớp với yêu cầu của Route không
            foreach ($roles as $role) {
                if (in_array($role, $employeeRoles)) {
                    return $next($request); // Hợp lệ -> cho đi tiếp
                }
            }

            // Nếu vòng lặp chạy xong mà không có quyền nào khớp -> Chặn
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        // Nếu chưa đăng nhập, đá về trang login
        return redirect()->route('login');
    }
}
