<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\User;
use Auth;
use File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_admin', null)->orderBy('id', 'DESC')->get();
        return view('admin.user.index')
            ->with(compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required',
            'username'          => 'required|unique:users',
            'email'             => 'required|unique:users',
            'password'          => 'required|min:6',
            'password_confirm'  => 'required_with:password|same:password|min:6',
            'user_image'        => 'required'
        ]);

        $fileName = null;
        if (request()->File('user_image'))
        {
            $file = request()->File('user_image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/admin/assets/images/user'), $fileName);
        }
   
        User::create([
            'name'          => $request->name,
            'username'      => $request->username,
            'email'         => $request->email,
            'designation'   => $request->designation,
            'phone_no'      => $request->phone_no,
            'address'       => $request->address,
            'group_id'      => 0,
            'password'      => Hash::make($request->password_confirm),
            'status'        => 'DEACTIVE',
            'user_image'    => $fileName
        ]);
    
        return redirect()->to('/admin/user')->with(['message' => 'User Created Successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.user.edit')
            ->with(compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'           => 'required',
            'username'       => [
                'required',
                'string',
                Rule::unique('users')->ignore($id)
            ],
            'email'          => [
                'required',
                'string',
                Rule::unique('users')->ignore($id)
            ]
        ]);

        $user = User::findOrFail($id);

        $currentImage = $user->user_image;

        $fileName = null;
        if (request()->File('user_image'))
        {
            unlink('./admin/assets/images/user/' . $currentImage);
            $file = request()->File('user_image');
            $fileName = md5($file->getClientOriginalName()) . time() . "." . $file->getClientOriginalExtension();
            $file->move(public_path('/admin/assets/images/user'), $fileName);
        }

        $user->update([
            'name'          => $request->name,
            'username'      => $request->username,
            'email'         => $request->email,
            'designation'   => $request->designation,
            'phone_no'      => $request->phone_no,
            'address'       => $request->address,
            'user_image'    => ($fileName) ? $fileName : $currentImage
        ]);
        
        if ($request->password || $request->password_confirm) {
            $request->validate([
                'password'          => 'required|min:6',
                'password_confirm'  => 'required_with:password|same:password|min:6'
            ]);

            $user->update([
                'password'      => Hash::make($request->password_confirm),
            ]);
        }
    
        return redirect()->to('/admin/user')->with(['message' => 'User Updated Successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete(Request $request)
    {
        User::find($request->userID)->delete();
        return true;
    }

    public function changeStatus(Request $request)
    {
        $user = User::find($request->userID);
        if ($user->status == 'ACTIVE') {
            $user->update(['status' => 'DEACTIVE']);
            return 'DEACTIVE';
        } else {
            $user->update(['status' => 'ACTIVE']);
            return 'ACTIVE';
        }
    }

    public function profile($id)
    {
        if (Auth::id() == $id || Auth::user()->is_admin == 1) {
            $user = User::findOrFail($id);
            return view('user-profile')
                ->with(compact('user'));
        }

        abort(404);
    }

    public function updateProfile(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'name'           => 'required',
            'username'       => [
                'required',
                'string',
                Rule::unique('users')->ignore($id)
            ],
            'email'          => [
                'required',
                'string',
                Rule::unique('users')->ignore($id)
            ]
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
        } else {
            $user = User::findOrFail($id);
            $user->update([
                'name'          => $request->name,
                'username'      => $request->username,
                'email'         => $request->email,
                'designation'   => $request->designation,
                'phone_no'      => $request->phone_no,
                'address'       => $request->address,
            ]);

            $response = [
                'status'  => true,
                'user'    => $user
            ];
        }


        return response()->json($response);
    }

    public function changePassword(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $validator = Validator::make($request->all(), [
            'user_id'          => 'required|numeric|gt:0|exists:users,id',
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!\Hash::check($value, $user->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'new_password'      => 'min:6|required_with:retype_password|same:retype_password',
            'retype_password'   => 'min:6'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
        } else {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            $response = [
                'status' => true
            ];
        }

        return response()->json($response);
    }

    public function updateProfileImage(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id'    => 'required|gt:0|exists:users,id',
            'user_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($validator->fails()) {
            $response = [
                'status' => false,
                'errors' => $validator->errors()
            ];
        } else {
            $user       = User::findOrFail($request->user_id);

            if ($user->user_image != null) {
                $image_path = public_path('\admin\assets\images\user') . '/\/' . $user->user_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }

            $user_image = time().'.'.$request->user_image->extension();

            $updateImage = $user->update([
                'user_image' => $user_image
            ]);

            if ($updateImage) {
                $request->user_image->move(public_path('/admin/assets/images/user'), $user_image);
                $response = [
                    'status'      => true,
                    'user_id'     => Auth::id(),
                    'user_image'  => $user_image
                ];
            } else {
                $response = [
                    'status'      => false
                ];
            }
        }

        return response()->json($response);
    }
}
