<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\WikiHeaderDataTable;
use App\Helpers\PermissionCommon;
use App\Models\WikiHeader;

class WikiHeaderController extends Controller {

    public function index(WikiHeaderDataTable $dataTable) {
        if(!PermissionCommon::check('wiki_header.list')) abort('403');
        
        return $dataTable->render('pages.wiki.header.index');
    }

    public function create() {
        if(!PermissionCommon::check('wiki_header.create')) abort('403');
        return view('pages.wiki.header.create');
    }
    
    public function store(Request $request) {
        if(!PermissionCommon::check('wiki_header.create')) abort('403');

        $request->validate([
            'versi' => 'required',
            'keterangan' => 'required',
        ]);
        
        $wiki = new WikiHeader();
        $wiki->versi = $request->versi;
        $wiki->keterangan = $request->keterangan;
        $wiki->save();
        
        if($wiki){
            return redirect()->route('wiki_header.index')->with(['success' => 'Data Saved Successfully!']);
        }else{
            return redirect()->route('wiki_header.index')->with(['error' => 'Data Failed to Save!']);
        }
    }

    public function show($id) {
        if(!PermissionCommon::check('wiki_header.show')) abort('403');

        $wiki = WikiHeader::find($id);
        return view('pages.wiki.header.show', compact('wiki'));
    }

    public function edit($id) {
        if(!PermissionCommon::check('wiki_header.update')) abort('403');

        $data = WikiHeader::find($id);
        return view('pages.wiki.header.edit', compact('id', 'data'));
    }

    public function update(Request $request, $id) {
        if(!PermissionCommon::check('wiki_header.update')) abort('403');

        $request->validate([
            'versi' => 'required',
            'keterangan' => 'required',
        ]);
        
        $wiki = WikiHeader::find($id);
        $wiki->versi = $request->versi;
        $wiki->keterangan = $request->keterangan;
        $wiki->save();
        
        if($wiki){
            return redirect()->route('wiki_header.index')->with(['success' => 'Data Saved Successfully!']);
        }else{
            return redirect()->route('wiki_header.index')->with(['error' => 'Data Failed to Save!']);
        }
    }

    public function destroy($id) {
        if(!PermissionCommon::check('wiki_header.delete')) return response()->json([
            'message' => "You don't have permission to access this action"
        ]);

        try {
            $wiki = WikiHeader::find($id);
            $delete = $wiki->delete();
            if($delete){
                return response()->json([
                    'message' => 'Data Deleted Successfully!'
                ]);
            }
            return response()->json([
                'message' => 'Data Failed Successfully!'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Data Failed, this data is still used in other modules !'
            ]);
        }
    }
}