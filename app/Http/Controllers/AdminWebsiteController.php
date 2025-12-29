<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use DataTables;

class AdminWebsiteController extends Controller
{
    public function index()
    {  
        
        $this->data['title'] = 'Website Setting';
        $this->data['sub_title'] = 'Setting'; 

        return view('admin.website.index', $this->data);
    }
 
    // AdminWebsiteController.php
    public function json(Request $request)
    {
        try {
            $settings = \DB::table('settings')->get();
            
            // Return dalam format yang sederhana
            return response()->json([
                'success' => true,
                'data' => $settings,
                'count' => $settings->count(),
                'timestamp' => now()->toDateTimeString()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    public function edit($id)
    {
        $setting = \DB::table('settings')->where('id', $id)->first();
        
        if (!$setting) {
            return response()->json(['error' => 'Setting not found'], 404);
        }
        
        return response()->json($setting);
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:settings,key',
            'value' => 'required'
        ]);
        
        $id = \DB::table('settings')->insertGetId([
            'key' => $request->key,
            'value' => $request->value
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Setting created successfully',
            'id' => $id
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => 'required|unique:settings,key,' . $id,
            'value' => 'required'
        ]);
        
        \DB::table('settings')
            ->where('id', $id)
            ->update([
                'key' => $request->key,
                'value' => $request->value
            ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Setting updated successfully'
        ]);
    }

    public function destroy($id)
    {
        \DB::table('settings')->where('id', $id)->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Setting deleted successfully'
        ]);
    }
}