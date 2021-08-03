<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://www.bootcdn.cn">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="keywords" content="OLAINDEX,OneDrive,Index,Microsoft OneDrive,Directory Index"/>
    <meta name="description" content="OLAINDEX,Another OneDrive Directory Index"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/favicon.ico"/>
    <meta name="theme-color" content="#fff"/>
    <title>OLAINDEX</title>
    <link href="https://cdn.bootcdn.net/ajax/libs/mdui/1.0.1/css/mdui.min.css" rel="stylesheet">
    <link href="https://cdn.bootcdn.net/ajax/libs/github-markdown-css/4.0.0/github-markdown.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/mdui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/notosans.css') }}">
    @stack('stylesheet')
    {!! setting('stats_code') !!}
    <script>
        const App = {
            'routes': {
                'upload_image': '{{ route('image.upload') }}',
            },
            '_token': '{{ csrf_token() }}',

        }
        const IconValues = {
            'music': 'audiotrack',
            'video': 'ondemand_video',
            'img': 'image',
            'pdf': 'picture_as_pdf',
            'default': 'insert_drive_file',
        }
    </script>
</head>
<body class="mdui-appbar-with-toolbar mdui-theme-layout-auto mdui-theme-accent-pink mdui-loaded">
<div id="top" class="anchor"></div>
@include('mdui.layouts.appbar')
@include('mdui.layouts.drawer')
<div class="mdui-container" style="min-height: 750px">
    @yield('content')
</div>
<footer class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-xs-12">
            <div class="mdui-typo-subheading-opacity mdui-text-center">
                {!! marked(setting('copyright','Designed
                by [IMWNK](https://imwnk.cn/) | Powered by [OLAINDEX](https://git.io/OLAINDEX)'),true) !!}
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.bootcdn.net/ajax/libs/mdui/1.0.1/js/mdui.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/axios/0.21.0/axios.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/store.js/2.0.0/store.everything.min.js"></script>
<script>
    const $ = mdui.$
    window.mdui = mdui
    window.theme = {
        toggle_theme: () => {
            let darkMode = store.get('darkMode')
            if (typeof (darkMode) == 'undefined' || darkMode === null) {
                darkMode = false
            }
            if (darkMode) {
                $('body').removeClass('mdui-theme-layout-dark')
                store.set('darkMode', false)
            } else {
                $('body').addClass('mdui-theme-layout-dark')
                store.set('darkMode', true)
            }
        },
        mutation: () => {
            $('body').removeClass('mdui-theme-layout-auto')
            let darkMode = store.get('darkMode')
            if (typeof (darkMode) == 'undefined' || darkMode === null) {
                if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    store.set('darkMode', true)
                    $('body').addClass('mdui-theme-layout-dark')
                } else {
                    store.set('darkMode', false)
                    $('body').removeClass('mdui-theme-layout-dark')
                }
            }
            if (!darkMode) {
                $('body').removeClass('mdui-theme-layout-dark')
                store.set('darkMode', false)
            } else {
                $('body').addClass('mdui-theme-layout-dark')
                store.set('darkMode', true)
            }
        },
    }
    $(function() {
        window.theme.mutation()
        let clipboard = new ClipboardJS('.clipboard')
        clipboard.on('success', function(e) {
            mdui.snackbar({
                position: 'right-top',
                message: '已复制',
            })
            console.info('Action:', e.action)
            console.info('Text:', e.text)
            console.info('Trigger:', e.trigger)
            e.clearSelection()
        })
        clipboard.on('error', function(e) {
            console.error('Action:', e.action)
            console.error('Trigger:', e.trigger)
        })
        $('#toggle-drawer').on('click', () => {
            new mdui.Drawer('#main-drawer', {
                swipe: true,
            }).toggle()
        })
        @if (session()->has('alertMessage'))
        mdui.snackbar({
            message: '{{ session()->pull('alertMessage') }}',
            position: 'right-top',
        })
        @endif
    })
</script>
@stack('scripts')
</body>
</html>
