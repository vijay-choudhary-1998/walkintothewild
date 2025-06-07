<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Walk into the Wild' }}</title>
    <!--favicon-->
    <link rel="icon" href="{{ asset('assets/images/WLogoLightgreen.svg') }}" type="image/png">
    <!--plugins-->
    <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/dark-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/semi-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header-colors.css') }}">
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .modal {
            overflow-y: auto !important;
        }

        span.select2-selection.select2-selection--single {
            height: auto;
            border-color: #ced4da !important;
        }

        span.select2-selection__rendered {
            padding: 0.275rem 1rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 0.275rem !important;
        }

        .select2-dropdown {
            z-index: 999999 !important;
        }
    </style>
    @include('components.includes.sweet-alert')
    @livewireStyles

</head>

<body>
    <div class="wrapper">
        @include('components.includes.admin-header')
        @include('components.includes.admin-sidebar')
        <div class="page-wrapper">
            <div class="page-content">
                {{ $slot }}
            </div>
        </div>
    </div>

    @include('components.includes.admin-footer')

    @livewireScripts


    <!---------------|| Js Files ||--------------->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!--app JS-->
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/js/Chart.extension.js') }}"></script>
    <script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/plugins/morris/js/morris.js') }}"></script>
    <script src="{{ asset('assets/js/index2.js') }}"></script>


    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script data-navigate-once>
        document.addEventListener("livewire:navigated", function() {
            $('select.select2').each(function() {
                const selectId = $(this).attr('id');
                const placeholder = $(this).attr('placeholder') || 'Select an option';

                $(this).select2({
                    placeholder
                }).on('change', function() {
                    const value = $(this).val();
                    const component = Livewire.first(); 
                    if (component) {
                        component.set(selectId, value);
                    }
                });
            });
        });
        document.addEventListener('livewire:init', () => {
            $('select.select2').each(function() {
                const selectId = $(this).attr('id');
                const placeholder = $(this).attr('placeholder') || 'Select an option';

                $(this).select2({
                    placeholder
                }).on('change', function() {
                    const value = $(this).val();
                    const component = Livewire.first();
                    if (component) {
                        component.set(selectId, value);
                    }
                });
            });
        });

        Livewire.hook('morphed', (message, component) => {
            $('select.select2').each(function() {
                const selectId = $(this).attr('id');
                const placeholder = $(this).attr('placeholder') || 'Select an option';

                $(this).select2({
                    placeholder
                }).on('change', function() {
                    const value = $(this).val();
                    const component = Livewire.first();
                    if (component) {
                        component.set(selectId, value);
                    }
                });
            });
        });
    </script>

</body>

</html>
