<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Inertia\Inertia;
use Validator;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // echo '<pre>'; print_r($request->documents); exit;
        try{

            $validator = Validator::make($request->all(), [
                'documents.*'=>'required|mimes:jpg,jpeg,png,pdf,txt,doc,docx,xlsx|max:1024',
            ]);

            if($validator->fails())
                return redirect()->route('profile.edit')->with('error', $validator->errors());

            $docPath = '/uploads/documents/';
            foreach ($request->documents as $document) {
                $docName = time().'_'.$document->getClientOriginalName();

                if($document->move(public_path($docPath), $docName)){
                    Document::create([
                        'name'=> $docName,
                        'path'=> $docPath.$docName,
                        'user_id' => $request->user()->id
                    ]);
                }
            }

            return redirect()->route('profile.edit')->with('success', 'Document(s) uploaded');

        }catch(Throwable $e){
            return redirect()->route('profile.edit')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        try{
            $documentPath = $document->path;
            if($document->delete()){
                if(file_exists(public_path($documentPath)))
                    unlink(public_path($documentPath));

                return redirect()->route('profile.edit')->with('success', 'Document deleted!');
            }

            return redirect()->route('profile.edit')->with('error', 'Document not deleted!');
        }catch(Throwable $e){
            return redirect()->route('profile.edit')->with('error', $e->getMessage());
        }
    }
}