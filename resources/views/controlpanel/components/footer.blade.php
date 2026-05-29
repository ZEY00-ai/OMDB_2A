<footer class="main-footer">
    <div class="footer-left">
        Copyright &copy; <span id="year"></span>
        <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad Nauval Azhar</a>
    </div>
    <div class="footer-right">

    </div>
</footer>
</div>
</div>

<!-- General JS Scripts -->
<script src="{{asset('assets/modules/jquery.min.js')}}"></script>
<script src="{{asset('assets/modules/popper.js')}}"></script>
<script src="{{asset('assets/modules/tooltip.js')}}"></script>
<script src="{{asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('assets/modules/moment.min.js')}}"></script>
<script src="{{asset('assets/js/stisla.js')}}"></script>

<!-- JS Libraies -->
<script src="{{asset('assets/modules/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('assets/modules/chart.min.js')}}"></script>
<script src="{{asset('assets/modules/owlcarousel2/dist/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/modules/summernote/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

<!-- Page Specific JS File -->
<script src="{{asset('assets/js/page/index.js')}}"></script>

<!-- Template JS File -->
<script src="{{asset('assets/js/scripts.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script>
    const year = document.getElementById('year');
    year.innerHTML = new Date().getFullYear();
</script>

{{-- Pagination pembatasan halaman --}}
@isset($total)
    @if($total > 10)
        @php
            $currentPage = (int) request('page', 1);
            $totalPages = (int) ceil($total / 10);
        @endphp
        <div class="d-flex justify-content-center mt-4">
            <nav>
                <ul class="pagination">
                    {{-- Prev --}}
                    <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $currentPage - 1]) }}">
                            &laquo;
                        </a>
                    </li>

                    {{-- Page Numbers --}}
                    @for($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $i]) }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    {{-- Next --}}
                    <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                        <a class="page-link"
                            href="{{ route('movies.search', ['keyword' => request('keyword'), 'page' => $currentPage + 1]) }}">
                            &raquo;
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
@endisset

{{-- Script Favorite --}}
<script>
document.getElementById('favorite-btn').addEventListener('click', function () {
    const btn    = this;
    const imdbId = btn.dataset.imdb;
    const title  = btn.dataset.title;
    const year   = btn.dataset.year;
    const poster = btn.dataset.poster;
    const type   = btn.dataset.type;

    const isFavorite = btn.classList.contains('btn-danger');

    if (isFavorite) {
        // Hapus dari favorite
        fetch(`/controlpanel/favorites/${imdbId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-outline-danger');
                btn.querySelector('i').classList.remove('fas');
                btn.querySelector('i').classList.add('far');
                btn.querySelector('span').textContent = 'Add to Favorites';

                Swal.fire({
                    text: data.message,
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                Swal.fire({
                    text: data.message,
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
        .catch(() => {
            Swal.fire({
                text: 'Terjadi kesalahan.',
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });

    } else {
        // Tambah ke favorite
        fetch('/controlpanel/favorites', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ imdb_id: imdbId, title, year, poster, type }),
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-danger');
                btn.querySelector('i').classList.remove('far');
                btn.querySelector('i').classList.add('fas');
                btn.querySelector('span').textContent = 'Remove from Favorites';

                Swal.fire({
                    text: data.message,
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            } else {
                Swal.fire({
                    text: data.message,
                    icon: 'warning',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        })
        .catch(() => {
            Swal.fire({
                text: 'Terjadi kesalahan.',
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        });
    }
});
</script>
