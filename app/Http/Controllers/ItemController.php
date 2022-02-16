<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return Item::with(['category'])->orderBy('deadline', 'ASC')->where('completed', false)->where('in_progress', false)->get();
    }

    public function inProgress()
    {
        
        return Item::with(['category'])->orderBy('deadline', 'ASC')->where('in_progress', true)->where('completed', false)->get();
    }

    public function completed()
    {
        
        return Item::with(['category'])->orderBy('deadline', 'ASC')->where('completed', true)->get();
    }

    public function numbers()
    {
        $todo = count(Item::with(['category'])->orderBy('deadline', 'ASC')->where('completed', false)->where('in_progress', false)->get());   
        $progress = count(Item::with(['category'])->orderBy('deadline', 'ASC')->where('in_progress', true)->where('completed', false)->get());
        $completed = count(Item::with(['category'])->orderBy('deadline', 'ASC')->where('completed', true)->get());

        return response()->json(['todo' => $todo, 'progress' => $progress, 'completed' => $completed], 200);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        validator($request->all(),[
            'name' => 'required',
            'category_id' => 'required',
            'deadline' => 'required'
        ])->validate();

        $item = new Item();
        $item->name = $request->name;
        $item->category_id = $request->category_id;
        $item->deadline = $request->deadline;
        $item->save();

        return $item;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category) {
            return Item::with(['category'])->orderBy('deadline', 'ASC')->where('category_id', $category->id)->where('completed', false)->where('in_progress', false)->get();
        }
        return "not found";
    }
    public function showProgress($id)
    {
        $category = Category::find($id);
        if($category) {
            return Item::with(['category'])->orderBy('deadline', 'ASC')->where('category_id', $category->id)->where('in_progress', true)->where('completed', false)->get();
        }
        return "not found";
    }
    public function showCompleted($id)
    {
        $category = Category::find($id);
        if($category) {
            return Item::with(['category'])->orderBy('deadline', 'ASC')->where('category_id', $category->id)->where('completed', true)->get();
        }
        return "not found";
    }
    public function showNumbers($id)
    {
        $category = Category::find($id);
        if($category) {
            $todo = count(Item::with(['category'])->orderBy('deadline', 'ASC')->where('category_id', $category->id)->where('completed', false)->where('in_progress', false)->get());
            $progress = count(Item::with(['category'])->orderBy('deadline', 'ASC')->where('category_id', $category->id)->where('in_progress', true)->where('completed', false)->get());
            $completed = count(Item::with(['category'])->orderBy('deadline', 'ASC')->where('category_id', $category->id)->where('completed', true)->get());
            return response()->json(['todo' => $todo, 'progress' => $progress, 'completed' => $completed], 200);
        }
        return "not found";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $existingItem = Item::Find($id);

        if( $existingItem && $existingItem->in_progress) {

            $existingItem->completed = $request->completed ? true : false;
            $existingItem->completed_at = $request->completed ? SupportCarbon::now() : null;
            $existingItem->save();
            return $existingItem;
        }
        elseif($existingItem) {
            $existingItem->in_progress = $request->in_progress ? true : false;
            $existingItem->save();
            return $existingItem;
        }

        return "Item not found";
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingItem = Item::Find($id);

        if($existingItem) {

            $existingItem->delete();
            return "Item deleted";
        }

        return "Item not found";
    }
}
