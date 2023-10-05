@props(['page' => '', 'items' => []])
<div class="block-header">
    <div class="row clearfix">
        <div class="col-lg-5 col-md-5 col-sm-12">
            <h2>{{ $page ? $page : 'Dashboard' }}</h2>
            <ul class="breadcrumb padding-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="zmdi zmdi-home"></i></a></li>
                @if (count($items) > 0)
                    @foreach ($items as $title => $link)
                        <li class="breadcrumb-item">
                            <a href="{{ $link }}">{{ $title }}</a>
                        </li>
                    @endforeach
                @else
                    <li class="breadcrumb-item active">Dashboard</li>
                @endif
            </ul>
        </div>
        {{-- <div class="col-lg-7 col-md-7 col-sm-12">
            <div class="input-group m-b-0">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-addon">
                    <i class="zmdi zmdi-search"></i>
                </span>
            </div>
        </div> --}}
    </div>
</div>
