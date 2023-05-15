<x-admin::app-layout>
    <x-slot:script>
        @if (sysconf('watermark', default: 'off') == 'on')
            <script>
                require(['watermark'], function (Watermark) {
                    const user = @json(auth()->user());
                    Watermark.removeWatermark()
                    Watermark.setWaterMark({
                        w_texts: [user.email_mask, user.phone_mask, user.last_login_ip],
                        w_options: {
                            w_width: 280,
                            w_height: 120,
                            w_font: '0.8rem Vedana',
                            w_color: '#666',
                            w_opacity: '0.2',
                            w_zIndex: 9999999999
                        }
                    })
                })
            </script>
        @endif
    </x-slot:script>
</x-admin::app-layout>
