<div>
    <section class="pb-20">
        <div class="container px-4 w-full mx-auto flex flex-col items-center">
            <div class="w-full text-center mb-12">
                <h1 class="text-xl md:text-2xl lg:text-3xl uppercase font-bold">Dalam Angka</h1>
            </div>
            <div class="grid grid-cols-2 gap-4 w-full max-w-xl">
                <div x-data="{
                    count: 0,
                    target: {{ $totalClient }},
                    duration: 2000,
                    started: false,
                    startCounting() {
                        if (this.started) return;
                        this.started = true;
                
                        const increment = this.target / (this.duration / 16);
                        const update = () => {
                            this.count += increment;
                            if (this.count < this.target) {
                                requestAnimationFrame(update);
                            } else {
                                this.count = this.target;
                            }
                        };
                        update();
                    }
                }" x-intersect.once="startCounting()">
                    <div class="card flex flex-col items-center p-6">
                        <span class="countdown font-mono text-xl md:text-2xl lg:text-3xl font-bold"
                            x-text="Math.floor(count).toLocaleString() + '+'"></span>
                        <p class="text-sm md:text-base lg:text-lg mt-2">Nasabah</p>
                    </div>
                </div>

                <div x-data="{
                    count: 0,
                    target: {{ $totalWaste }},
                    duration: 2000,
                    started: false,
                    startCounting() {
                        if (this.started) return;
                        this.started = true;
                
                        const increment = this.target / (this.duration / 16);
                        const update = () => {
                            this.count += increment;
                            if (this.count < this.target) {
                                requestAnimationFrame(update);
                            } else {
                                this.count = this.target;
                            }
                        };
                        update();
                    }
                }" x-intersect.once="startCounting()">

                    <div class="card flex flex-col items-center p-6">
                        <span class="countdown font-mono text-xl md:text-2xl lg:text-3xl font-bold"
                            x-text="Math.floor(count).toLocaleString() + '+'"></span>
                        <p class="text-sm md:text-base lg:text-lg mt-2">Sampah terkumpul (Kg)</p>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>
