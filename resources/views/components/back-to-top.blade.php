<div id="to-top"
    class="cursor-pointer fixed md:bottom-24 bottom-[4.5rem] md:right-10 right-4 h-12 w-12 rounded-full border border-solid border-slate-300 bg-primary items-center justify-center hover:opacity-75 z-10 flex"
    onclick="window.scrollTo({top: 0,behavior: 'smooth'})" style="box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.25)"
    title="To the top">

    @svg('top-circle', 'fill-white')

    @push('scripts')
        <script type="application/javascript">
            document.addEventListener("DOMContentLoaded", function () {
                window.addEventListener("scroll", function () {
                    if (this.scrollY > 500) {
                        document.getElementById('to-top').classList.remove('hidden');
                    } else {
                        document.getElementById('to-top').classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
</div>
