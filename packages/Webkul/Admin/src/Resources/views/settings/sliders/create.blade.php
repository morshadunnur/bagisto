@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.settings.sliders.add-title') }}
@stop

@section('content')
    <div class="content">
        <form
            method="POST"
            @submit.prevent="onSubmit"
            enctype="multipart/form-data"
            action="{{ route('admin.sliders.create') }}">

            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('admin.sliders.index') }}'"></i>

                        {{ __('admin::app.settings.sliders.add-title') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.settings.sliders.save-btn-title') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                <div class="form-container">
                    @csrf()

                    {!! view_render_event('bagisto.admin.settings.slider.create.before') !!}

                    <div class="control-group" :class="[errors.has('locale[]') ? 'has-error' : '']">
                        <label for="locale">{{ __('admin::app.datagrid.locale') }}</label>

                        <select class="control" id="locale" name="locale[]" data-vv-as="&quot;{{ __('admin::app.datagrid.locale') }}&quot;" value="" v-validate="'required'" multiple>
                            @foreach (core()->getAllLocales() as $localeModel)

                                <option value="{{ $localeModel->code }}">
                                    {{ $localeModel->name }}
                                </option>

                            @endforeach
                        </select>

                        <span class="control-error" v-if="errors.has('locale[]')">@{{ errors.first('locale[]') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('title') ? 'has-error' : '']">
                        <label for="title" class="required">{{ __('admin::app.settings.sliders.name') }}</label>
                        <input type="text" class="control" name="title" v-validate="'required'" data-vv-as="&quot;{{ __('admin::app.settings.sliders.name') }}&quot;">
                        <span class="control-error" v-if="errors.has('title')">@{{ errors.first('title') }}</span>
                    </div>

                    <?php $channels = core()->getAllChannels() ?>
                    <div class="control-group" :class="[errors.has('channel_id') ? 'has-error' : '']">
                        <label for="channel_id">{{ __('admin::app.settings.sliders.channels') }}</label>
                        <select class="control" id="channel_id" name="channel_id" v-validate="'required'" data-vv-as="&quot;{{ __('admin::app.settings.sliders.channels') }}&quot;">
                            @foreach ($channels as $channel)
                                <option value="{{ $channel->id }}" @if ($channel->id == old('channel_id')) selected @endif>
                                    {{ __(core()->getChannelName($channel)) }}
                                </option>
                            @endforeach
                        </select>
                        <span class="control-error" v-if="errors.has('channel_id')">@{{ errors.first('channel_id') }}</span>
                    </div>

                    <div class="control-group date">
                        <label for="expired_at">{{ __('admin::app.settings.sliders.expired-at') }}</label>
                        <date>
                            <input type="text" name="expired_at" class="control" value="{{ old('expired_at') }}"/>
                        </date>
                    </div>

                    <div class="control-group">
                        <label for="sort_order">{{ __('admin::app.settings.sliders.sort-order') }}</label>
                        <input type="text" class="control" id="sort_order" name="sort_order" value="{{ old('sort_order') ?? 0 }}"/>
                    </div>

                    <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                        <label class="required">{{ __('admin::app.catalog.categories.image') }}</label>

                        <image-wrapper :button-label="'{{ __('admin::app.settings.sliders.image') }}'" input-name="image" :multiple="false"></image-wrapper>

                        <span class="control-error" v-if="{!! $errors->has('image.*') !!}">
                            @foreach ($errors->get('image.*') as $key => $message)
                                @php echo str_replace($key, 'Image', $message[0]); @endphp
                            @endforeach
                        </span>
                    </div>

                    <div class="control-group" :class="[errors.has('content') ? 'has-error' : '']">
                        <label for="content">{{ __('admin::app.settings.sliders.content') }}</label>

                        <textarea id="tiny" class="control" id="add_content" name="content" rows="5"></textarea>

                        <span class="control-error" v-if="errors.has('content')">@{{ errors.first('content') }}</span>
                    </div>

                    {!! view_render_event('bagisto.admin.settings.slider.create.after') !!}
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('admin::layouts.tinymce')

    <script>
        $(document).ready(function () {
            tinyMCEHelper.initTinyMCE({
                selector: 'textarea#tiny',
                height: 200,
                width: "100%",
                plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code | table',
                image_advtab: true,
                templates: [
                    { title: 'Test template 1', content: 'Test 1' },
                    { title: 'Test template 2', content: 'Test 2' }
                ],
            });
        });
    </script>
@endpush
