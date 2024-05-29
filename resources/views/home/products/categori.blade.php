<div class="head">Category Sneaker</div>
<ul class="main-categories">
    <li class="main-nav-list">
        @foreach ($category as $item)
            <a href="/product?category_id={{ $item->id }}"><span
                    class="lnr lnr-arrow-right"></span>{{ $item->name }}</a>
        @endforeach
    </li>
</ul>
