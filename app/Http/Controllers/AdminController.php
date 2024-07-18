<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Product;

class AdminController extends Controller
{
    public function view_event() {
        return view('admin.event');
    }

    public function view_product() {
        return view('admin.product');
    }

    public function add_product(Request $request) {
        $product = new Product;

        $product->title = $request->title;
        $product->description = $request->description;
        $image = $request->image;

        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('product', $imagename);

        $product->image = $imagename;
        $product->save();

        return redirect()->back()->with('message', 'Product Added Successfully!');
    }

    public function add_event(Request $request) {
        $event = new Event;

        $event->title = $request->title;
        $event->description = $request->description;
        $event->location = $request->location;
        $event->date = $request->date;
        $image = $request->image;

        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('event', $imagename);

        $event->image = $imagename;
        $event->save();

        return redirect()->back()->with('message', 'Event Added Successfully!');
    }

    public function show_product() {
        $products = Product::all();
        return view('admin.show_product', compact('products'));
    }

    public function show_event() {
        $event = Event::all();
        return view('admin.show_event', compact('event'));
    }

    public function delete_product($id) {
        $product = Product::find($id);
        $product->delete();

        return redirect()->back()->with('message', 'Product Deleted Successfully!');
    }

    public function update_product($id) {
        $product = Product::find($id);
        return view('admin.update_product', compact('product'));
    }

    public function delete_event($id) {
        $event = Event::find($id);
        $event->delete();

        return redirect()->back()->with('message', 'Event Deleted Successfully!');
    }

    public function update_event($id) {
        $event = Event::find($id);
        return view('admin.update_event', compact('event'));
    }

    public function update_product_confirm(Request $request, $id) {
        $product = Product::find($id);

        $product->title = $request->title;
        $product->description = $request->description;

        $image = $request->image;
        if ($image) {
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('product', $imagename);
            $product->image = $imagename;
        }

        $product->save();
        return redirect()->back();
    }
}
