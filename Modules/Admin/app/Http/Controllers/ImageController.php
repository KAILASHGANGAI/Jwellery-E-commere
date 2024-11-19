<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Repositories\CommonRepository;
use Modules\Admin\Models\Image;
use Modules\Admin\Services\AdminComonService;

class ImageController extends Controller
{
    private CommonRepository $comReo;
    private AdminComonService $adminService;
    public function __construct(AdminComonService $adminService)
    {
        $this->adminService = $adminService;
        $this->comReo = new CommonRepository(Image::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('admin::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       $image =  $this->comReo->find($id);

       if (file_exists($image->image_path)) {
           unlink($image->image_path);
       }
       $this->comReo->delete($id);
       return response()->json(['success' => 'Deleted successfully.']);
    }
}
