<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
//use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = auth()->user()
            ->products()->with('category')
            ->latest()
            ->paginate(5); //->simplePaginate(5); //->get(); //dd($products);

        return Inertia::render('product/Index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return Inertia::render('product/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        //Product::create($request->validated() + ['user_id' => $request->user()->id]);  //1 st way
        //$request->user()->products()->create($request->validated()); // 2nd way

        $payload = $request->validated();
        if ($request->hasFile('image')) {
            $payload['image'] = $this->handleUploadedFile($request);
        }

        $request->user()->products()->create($payload);

        return redirect()->route('products.index');
    }

    protected function handleUploadedFile($request)
    {
        $folder = "images/" . date('Y/m'); // "images";
        $fileName = Str::uuid() . '.' . $request->file('image')->getClientOriginalName();
        return  $request->file('image')->storeAs($folder, $fileName);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // таблица не та? но чуть поправил ...
        $product->load('category'); //dd($product);

        return Inertia::render('product/Show', [
            'product' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // time 1:19:25
        return Inertia::render('product/Edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductRequest $request, Product $product)
    {
        $payload = $request->except('image');
        if ($request->hasFile('image')) {
            // remove old image
            if (!is_null($product->image) && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }

            // upload new image
            $payload['image'] = $this->handleUploadedFile($request);
        }

        $product->update($payload);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // remove image if exists
        if (!is_null($product->image) && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index');
    }
}
