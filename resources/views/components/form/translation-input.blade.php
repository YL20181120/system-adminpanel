<?php /** @var \Central\Models\Menu $model */ ?>
@props([
    'label' => '',
    'name' => '',
    'help' => '',
    'model' => null
])

<div class="layui-form-item">
    <label class="layui-form-label">{{ $label }}</label>
    <div class="layui-input-block">
        <div class="grid grid-cols-2 gap-4">
            @foreach(config('translatable.locales') as $locale)
                <div style="display: flex; border: 1px solid #EEE;">
                    <div
                        style="width: 80px; display: flex;align-items: center; justify-content: center">{{ \Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales()[$locale]['native'] }}</div>
                    <input type="text" class="layui-input" style="border: none;border-left: 1px solid #EEE"
                           name="{{$locale}}:{{$name}}"
                           value="{{ $model->translate($locale)?->{$name} }}">
                </div>
            @endforeach
        </div>
        @if (!empty($help))
            <p class="help-block">
                {!! $help !!}
            </p>
        @endif
    </div>
</div>
