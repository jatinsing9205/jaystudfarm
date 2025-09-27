<!DOCTYPE html>
<html>
<head>
    <title>HTML Sitemap</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>HTML Sitemap</h1>

    <h2>Static Pages</h2>
    <ul>
        @foreach($staticPages as $page)
            <li><a href="{{ url($page['url']) }}">{{ $page['title'] }}</a></li>
        @endforeach
    </ul>

    <h2>Categories</h2>
    <ul>
        @foreach($categories as $category)
            <li>
                <a href="{{ url('/category/' . $category->id) }}">
                    Category #{{ $category->id }}
                </a>
            </li>
        @endforeach
    </ul>

    <h2>Products</h2>
    <ul>
        @foreach($products as $product)
            <li>
                <a href="{{ url('/product-details/' . $product->product_id) }}">
                    Product #{{ $product->product_id }}
                </a>
            </li>
        @endforeach
    </ul>
</body>
</html>
