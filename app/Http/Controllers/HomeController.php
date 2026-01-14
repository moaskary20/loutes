<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->ordered()->get();
        $siteSettings = SiteSetting::getSettings();
        $products = \App\Models\Product::where('is_active', true)
            ->where('is_featured', true)
            ->with('images')
            ->limit(8)
            ->get();
        
        return view('home', compact('sliders', 'siteSettings', 'products'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function about()
    {
        return view('about');
    }

    public function careers()
    {
        return view('careers');
    }

    public function products(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('name_en')->get();

        $query = Product::where('is_active', true)->with(['images', 'category', 'reviews']);

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Validate that max_price is greater than or equal to min_price
        if ($minPrice && $maxPrice && $maxPrice < $minPrice) {
            return redirect()->route('products', $request->except('max_price'))
                ->with('error', 'Maximum price must be greater than or equal to minimum price.');
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $minPrice);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        if ($request->filled('categories')) {
            $query->whereIn('category_id', (array) $request->input('categories'));
        }

        if ($request->filled('rating')) {
            $minRating = (int) $request->input('rating');
            $query->whereHas('reviews', function ($q) use ($minRating) {
                $q->where('rating', '>=', $minRating);
            });
        }

        $products = $query->paginate(12);

        return view('products', compact('categories', 'products'));
    }

    public function product(Product $product)
    {
        // التأكد من أن المنتج نشط
        if (!$product->is_active) {
            abort(404);
        }

        // جلب المنتج مع العلاقات
        $product->load(['images', 'category', 'reviews']);

        // جلب منتجات مشابهة (نفس القسم أو منتجات مميزة)
        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                if ($product->category_id) {
                    $query->where('category_id', $product->category_id)
                        ->orWhere('is_featured', true);
                } else {
                    $query->where('is_featured', true);
                }
            })
            ->with('images')
            ->limit(4)
            ->get();

        return view('product', compact('product', 'relatedProducts'));
    }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // هنا يمكنك إضافة منطق إرسال الإيميل أو حفظ الرسالة في قاعدة البيانات
        // على سبيل المثال:
        // Mail::to('info@lotussnacks.com')->send(new ContactFormMail($validated));

        return redirect()->route('contact')->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
