<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HTML E-mail Editor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

		<link rel="icon" type="image/x-icon" href="<?php echo asset('logo.svg') ?>">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans">

		<header class="astronav-sticky-header sticky top-0 border-b z-20 transition-all py-5 border-transparent"> 
			<div class="max-w-screen-xl mx-auto px-5"> 
				<div class="flex flex-col lg:flex-row justify-between items-center relative z-10" data-astro-transition-scope="astro-o7bz76pi-1"> 
					<div class="flex w-full lg:w-auto items-center justify-between"> 
						<a href="/" class="text-lg flex items-center transition gap-3 focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500 focus-visible:outline-none focus-visible:shadow-outline-indigo rounded-full px-2 -ml-2">
							<img src="<?php echo asset('logo.svg') ?>" class="max-w-[80px]"> HTML E-mail Editor
						</a>
					</div> 
					<!-- DESKTOP -->
					<div> 
						<div class="hidden lg:flex items-center gap-4"> 
							<a href="{{ route('login') }}" class="text-sm px-2 py-1 transition focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500 focus-visible:outline-none focus-visible:shadow-outline-indigo rounded-full">Log in</a> 
							<a href="{{ route('register') }}" class="rounded-full text-center transition focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500 focus-visible:outline-none focus-visible:shadow-outline-indigo px-4 py-2 text-sm bg-indigo-600 text-white hover:bg-indigo-800 inline-flex items-center group gap-px"> 
								<span>Create account</span> 
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mt-px group-hover:translate-x-1 transition-transform"> 
									<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd">
									</path> 
								</svg> 
							</a> 
						</div> 
					</div> 
				</div> 
			</div> 
		</header>

		<div class="overflow-x-clip">
			<div class="max-w-screen-xl mx-auto px-5">
				<main class="grid lg:grid-cols-5 place-items-center relative">
					<div class="absolute w-96 h-96 blur-2xl -z-10 bg-gradient-radial from-indigo-200 right-0 top-0"></div>
					<div class="absolute w-96 h-96 blur-2xl -z-10 bg-gradient-radial from-purple-200 right-56 top-10"></div>
					<div class="max-w-sm md:max-w-max lg:col-span-2">
						<h1 class="text-3xl lg:text-4xl xl:text-6xl font-bold lg:tracking-tight xl:tracking-tighter [text-wrap:balance] text-center lg:text-start">
							Create <span class="text-[#3b82f6]">HTML E-mails</span> Easily <br>
							<span class="text-[#f63b86]">without code</span>
						</h1>
						<p class="text-lg mt-4 max-w-lg text-slate-600 [text-wrap:balance] text-center lg:text-start">
						Create highly customized emails, visually without coding, producing code compatible with the main email clients.
						</p>
						<div class="mt-6 flex flex-col sm:flex-row sm:justify-center lg:justify-start gap-3"> 
							<a href="{{ route('login') }}" target="_blank" rel="noopener" class="rounded-full text-center transition focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500 focus-visible:outline-none focus-visible:shadow-outline-indigo px-7 py-2.5 bg-indigo-600 text-white hover:bg-indigo-800 flex gap-1 items-center justify-center">
							Log in
							</a> 
							<a href="{{ route('register') }}" rel="noopener" target="_blank" class="rounded-full text-center transition focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-indigo-500 focus-visible:outline-none focus-visible:shadow-outline-indigo px-7 py-2.5 bg-white border-2 border-indigo-500 hover:bg-indigo-50 text-indigo-600  flex gap-1 items-center justify-center">
							Create account
							</a> 
						</div>
					</div>
					<div class="py-3 lg:col-span-3 lg:-mr-44">
						<picture>
							<img class="block max-w-full border-2  border-solid border-[#f63b86] rounded-xl shadow-2xl" src="<?php echo asset('feature-editor.png') ?>" alt="Html email editor" loading="eager" fetchpriority="high" width="1183" height="787" decoding="async"> 
						</picture>
					</div>
				</main>
			</div>
		</div>


    </body>
</html>
