<div class="head">Brands</div>
                    <ul class="main-categories">
                        <li class="main-nav-list">
                            @foreach ($brand as $item )
                            <a  href="{{ route('brand',['id'=>$item->id])}}"
                           ><span class="lnr lnr-arrow-right"></span>{{ $item->name }}</a>
                            @endforeach


                        </li>
                    </ul>
