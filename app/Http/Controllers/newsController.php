<?php

namespace App\Http\Controllers;

use App\News;
use App\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class newsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_news = News::orderBy('id','desc')->paginate(10);
        $title = 'All News';
        return view('news.index',compact('all_news','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create News';
        return view('news.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title'     => 'required',
            'desc'      => 'required',
            'content'   => 'required',
            'photo'     => 'required|image|mimes:jpg,jpeg,png',
            'files.*'   => 'image|mimes:jpg,jpeg,png',
            'user_id'   => 'required',
        ];
        $niceName = [
            'title'   => 'Title',
            'desc'    => 'Description',
            'content' => 'Content',
            'photo'   => 'Photo',
            'user_id' => 'User Id',
        ];
        $data = $this->validate($request,$rules,[],$niceName);
        $tempFolder = time();
        $data['photo']   = $request->photo->store('images/'.$tempFolder);
        $data['user_id'] = auth()->user()->id;
        $news = News::create($data);

        foreach ($request->file('files') as $file){
            Storage::makeDirectory('images/'.$news->id);
            $uploadFile = $file->store('images/'.$news->id);
            Files::create([
                'user_id'   => auth()->user()->id,
                'news_id'   => $news->id,
                'path'      => 'images/'.$news->id,
                'file'      => $uploadFile,
                'file_name' => $file->getClientOriginalName(),
                'size'      => Storage::size($uploadFile),
            ]);
        }

        $newName = str_replace($tempFolder,$news->id,$news['photo']);
        Storage::rename($news['photo'],$newName);
        News::where('id',$news->id)->update(['photo' => $newName]);
        Storage::deleteDirectory('images/'.$tempFolder);
        session()->flash('success','The News Has Been Saved Successfully');
        return redirect('news');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $news = News::find($id);
        return view('news.show',['news' => $news,'title' => $news->title]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $news = News::find($id);
        return view('news.edit',['title' => 'Edit Or Update News','news' => $news]);
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
        if ($request->has('delete_photo') and $request->has('file_id')){
            foreach ($request->input('file_id') as $fid){
                $file = Files::find($fid);
                Storage::delete($file->file);
                $file->delete();
            }
            session()->flash('success','Photo Has Been Deleted Successfully');
            return redirect('news/'.$id.'/edit');
        }else{
            $rules = [
                'title'     => 'required',
                'desc'      => 'required',
                'content'   => 'required',
                'photo'     => 'image|mimes:jpg,jpeg,png',
                'files.*'   => 'image|mimes:jpg,jpeg,png',
                'user_id'   => 'required',
            ];
            $niceName = [
                'title'   => 'Title',
                'desc'    => 'Description',
                'content' => 'Content',
                'photo'   => 'Photo',
                'user_id' => 'User Id',
            ];
            $data = $this->validate($request,$rules,[],$niceName);
            $data['user_id'] = auth()->user()->id;
            $news = News::find($id);
            $data = $request->except(['files','_method','_token']);
            if ($request->hasFile('photo')){
                Storage::delete($news->photo);
                $data['photo']   = $request->photo->store('images/' . $id);
            }

            if ($request->hasFile('files')){
                foreach ($request->file('files') as $file){
                    $uploadFile = $file->store('images/'.$news->id);
                    Files::create([
                        'user_id'   => auth()->user()->id,
                        'news_id'   => $news->id,
                        'path'      => 'images/'.$news->id,
                        'file'      => $uploadFile,
                        'file_name' => $file->getClientOriginalName(),
                        'size'      => Storage::size($uploadFile),
                    ]);
                }
            }

            News::where('id',$news->id)->update($data);
            session()->flash('success','The News Has Been Saved Successfully');
            return redirect('news');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::find($id)->delete();
        Storage::deleteDirectory('images/'.$id);
        session()->flash('News Deleted Successfully');
        return redirect('news');
    }
}
