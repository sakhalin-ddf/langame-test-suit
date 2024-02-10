@extends('layouts.app')

@section('content')
    <h3 class="mb-4">Список категорий</h3>

    {!! \App\Helpers\Html::renderCategoryTreeMenu($categoryTree) !!}
@endsection
