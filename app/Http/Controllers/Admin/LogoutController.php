<?php
/**
 * Created by PhpStorm.
 * User: luojingying
 * Date: 17/6/7
 * Time: 下午5:39
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.admin']);
    }

    public function __invoke(Request $request)
    {
        Auth::guard()->logout();

        $request->session()->flash();

        $request->session()->regenerate();

        return redirect()->route('admin.login');
    }
}
