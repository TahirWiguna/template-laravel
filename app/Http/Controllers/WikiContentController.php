<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\WikiContentDataTable;
use App\Helpers\PermissionCommon;
use App\Models\WikiContent;
use App\Models\WikiHeader;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;

class WikiContentController extends Controller
{
    public function index(WikiContentDataTable $dataTable, Request $request)
    {
        if(!PermissionCommon::check('wiki_content.list')) abort('403');

        $wiki_header_id = $request->query('wiki_header_id');
        $wiki = WikiHeader::find($wiki_header_id);
        if(!$wiki) {
            return redirect()->route('wiki_header.index')->with(['error' => 'Data Not Found!']);
        }

        $dataTable->query(new WikiContent)->where('wiki_header_id', $wiki_header_id);
        // $dataTable->removeColumn('isi');

        return $dataTable->render('pages.wiki.content.index', compact('wiki_header_id', 'wiki'));
    }

    public function create(Request $request)
    {
        if(!PermissionCommon::check('wiki_content.create')) abort('403');
        
        $wiki_header_id = $request->query('wiki_header_id');
        $wiki = WikiHeader::find($wiki_header_id);
        if(!$wiki) {
            return redirect()->route('wiki_header.index')->with(['error' => 'Data Not Found!']);
        }

        return view('pages.wiki.content.create', compact('wiki_header_id'));
    }

    public function store(Request $request)
    {
        if(!PermissionCommon::check('wiki_content.create')) abort('403');

        $request->validate([
            'wiki_header_id' => 'required',
            'slug' => 'required',
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $wiki = new WikiContent();
        $wiki->wiki_header_id = $request->wiki_header_id;
        $wiki->slug = $request->slug;
        $wiki->judul = $request->judul;
        $wiki->isi = $request->isi;
        $wiki->save();

        if($wiki){
            return redirect()->route('wiki_content.index', [
                'wiki_header_id' => $wiki->wiki_header_id
            ])->with(['success' => 'Data Saved Successfully!']);
        }else{
            return redirect()->route('wiki_content.index', [
                'wiki_header_id' => $wiki->wiki_header_id
            ])->with(['error' => 'Data Failed to Save!']);
        }
    }

    public function show($id)
    {
        if(!PermissionCommon::check('wiki_content.show')) abort('403');

        $wiki = WikiContent::find($id);
        if(!$wiki) {
            return redirect()->route('wiki_content.index', [
                'wiki_header_id' => $wiki->wiki_header_id
            ])->with(['error' => 'Data Not Found!']);
        }
        return view('pages.wiki.content.show', compact('wiki'));
    }

    public function edit($id)
    {
        if(!PermissionCommon::check('wiki_content.update')) abort('403');

        $data = WikiContent::find($id);
        return view('pages.wiki.content.edit', compact('id', 'data'));
    }

    public function update(Request $request, $id)
    {
        if(!PermissionCommon::check('wiki_content.update')) abort('403');

        $request->validate([
            'wiki_header_id' => 'required',
            'slug' => 'required',
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $wiki = WikiContent::find($id);
        $wiki->wiki_header_id = $request->wiki_header_id;
        $wiki->slug = $request->slug;
        $wiki->judul = $request->judul;
        $wiki->isi = $request->isi;
        $wiki->save();

        if($wiki){
            return redirect()->route('wiki_content.index', [
                'wiki_header_id' => $wiki->wiki_header_id
            ])->with(['success' => 'Data Updated Successfully!']);
        }else{
            return redirect()->route('wiki_content.index', [
                'wiki_header_id' => $wiki->wiki_header_id
            ])->with(['error' => 'Data Failed to Update!']);
        }
    }

    public function destroy($id)
    {
        if(!PermissionCommon::check('wiki_header.delete')) return response()->json([
            'message' => "You don't have permission to access this action"
        ]);

        try {
            $wiki = WikiContent::find($id);
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

    public function pdf($id){
        $wiki = WikiContent::find($id);
        $pdf = PDF::loadHTML('<h1>'.$wiki->judul.'</h1><br>'.$wiki->isi);
        $judul_whitespace = str_replace(' ', '_', $wiki->judul);
        return $pdf->download($judul_whitespace.'.pdf');
    }

    public function help($versi, $key){
        //where using versi and key
        $wiki = DB::select("SELECT 
                wiki_contents.*
            FROM wiki_contents
            LEFT JOIN wiki_headers ON wiki_headers.id = wiki_contents.wiki_header_id
            WHERE wiki_headers.versi = '$versi' AND wiki_contents.slug = '$key'
        ");

        if(count($wiki) > 0){
            return response()->json([
                'title' => $wiki[0]->judul,
                'body' => $wiki[0]->isi,
                'footer' => '<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>'
            ]);
        }
        return response()->json([
            'title' => 'Panduan',
            'body' => 'Tidak ada panduan',
            'footer' => '<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>'
        ]);
        
    }
}
