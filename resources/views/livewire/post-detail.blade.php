<div>
    @section('title')
        {{ $post->title }}
    @endsection

    <section class="py-20">
        <div class="container mx-auto px-4 pt-10 flex flex-col items-center w-full space-y-12">

            <div class="max-w-5xl w-full space-y-4 text-center lg:text-left">
                <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold">
                    {{ $post->title }}
                </h1>
                <div
                    class="text-sm text-gray-600 dark:text-gray-300 flex flex-col sm:flex-row sm:gap-x-4 sm:items-center justify-center lg:justify-start">
                    <p>By {{ $post->user->name }}</p>
                    <p>{{ $post->human_read_time }}</p>
                </div>
            </div>

            <div class="max-w-5xl w-full">
                <div class="carousel w-full">
                    @foreach ($post->images as $image)
                        @php
                            $current = $loop->iteration;
                            $prev = $current === 1 ? $loop->count : $current - 1;
                            $next = $current === $loop->count ? 1 : $current + 1;
                        @endphp

                        <div id="slide{{ $current }}" class="carousel-item relative w-full">
                            <img src="{{ Storage::url($image) }}"
                                class="w-full h-36 sm:h-64 xl:h-96 object-cover rounded-md" />
                            <div
                                class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                                <a href="#slide{{ $prev }}" class="btn btn-circle">❮</a>
                                <a href="#slide{{ $next }}" class="btn btn-circle">❯</a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="max-w-3xl text-base leading-relaxed text-justify">
                <p>{{ $post->body }}</p>
            </div>

        </div>
    </section>
</div>
