@php 
    $footerData = App\Models\FooterTitle::with(['items' => function($query) {
        $query->active()->ordered();
    }])->active()->ordered()->get();

    $socialIcons = App\Models\Social::where('is_active', true)->orderBy('sort_order')->get();
@endphp

<section class="last_part">

    <div class="content_container">
        @foreach ($footerData as $index => $title)
        <div class="box_container4">
            <button class="mobile-toggle" data-target="footer-{{ $index }}">
                {{ $title->title }} <span class="chevron">&#9662;</span>
            </button>

            <ul class="footer-menu" id="footer-{{ $index }}">
                <li class="tittles">{{ $title->title }}</li>
                @foreach ($title->items as $item)
                <li class="items"><a href="{{ $item->url }}">{{ $item->text }}</a></li>
                @endforeach                                                        
            </ul>
        </div>
        @endforeach
    </div>

    <div class="social-icon-container">
        <div class="icons">
            @foreach ($socialIcons as $social)
            <li class="{{ Str::slug($social->icon) }} box">
                <a href="{{ $social->name_url }}" target="_blank">
                    <i class="{{ $social->icon }}"></i>
                </a>
            </li>
            @endforeach
        </div>
    </div>
</section>

<footer>
    <p class="mb-0">&copy; <span id="current-year"></span> Powered by Kumoyo Technologies.</p>
</footer>

<script>
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Mobile dropdown toggle (only one open)
    document.querySelectorAll('.mobile-toggle').forEach(button => {
        button.addEventListener('click', () => {
            const targetId = button.getAttribute('data-target');
            const targetMenu = document.getElementById(targetId);

            document.querySelectorAll('.footer-menu').forEach(menu => {
                if (menu.id !== targetId) {
                    menu.classList.remove('open');
                }
            });

            targetMenu.classList.toggle('open');
        });
    });
</script>

<style>
    .last_part {
    background: #fff;
    padding: 32px 0 0 0;
    border-top: 1px solid #e5e5e5;
    font-family: Arial, 'SamsungOne', sans-serif;
}

/* Main container centered */
.content_container {
    max-width: 1200px;
   
    display: flex;
    flex-wrap: nowrap;
    justify-content: center; /* Center horizontally */
    align-items: flex-start;
    
}

.box_container4 {
    flex: 1 1 0;
    min-width: 160px;
    padding: 0 32px;
    border-top: 1px solid #d1cfcf;
    border-right: 1px solid #d1cfcf;
    box-sizing: border-box;
}

.box_container4:last-child {
    border-right: none;
}

.box_container4 ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.tittles {
    font-weight: bold;
    font-size: 18px;
    color: #222;
    margin-bottom: 18px;
    margin-top: 0;
    padding-bottom: 6px;
    letter-spacing: 0.01em;
    text-align: center;
}

.items {
    font-size: 15px;
    margin-bottom: 11px;
    color: #222;
    line-height: 1.7;
    text-align: center;
}

.items a {
    color: #222;
    text-decoration: none;
    transition: color 0.2s;
    font-weight: 400;
}

.items a:hover {
    color: #1428a0;
    text-decoration: underline;
}

/* Social Icons */
.social-icon-container {
    width: 100%;
    border-top: 1px solid #e5e5e5;
    padding: 32px 0;
    margin-top: 32px;
    text-align: center;
}

.icons {
    display: flex;
    justify-content: center;
    gap: 16px;
    padding: 0;
}

.icons li {
    list-style: none;
}

.icons a {
    display: inline-block;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #f2f2f2;
    color: #707070;
    line-height: 38px;
    text-align: center;
    font-size: 18px;
    transition: background 0.2s, color 0.2s;
}

.icons a:hover {
    background: #1428a0;
    color: #fff;
}

/* Footer base */
footer {
    background: #fff;
    border-top: 1px solid #e5e5e5;
    text-align: center;
    padding: 18px 0 12px 0;
    font-size: 13px;
    color: #000000;
    width: 100%;
    margin: 0 auto;
}

footer p {
    margin: 0 auto;
}

/* Mobile dropdown toggle */
.mobile-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 18px;
    font-weight: bold;
    padding: 12px 0;
    color: #222;
    width: 100%;
    text-align: center;
    cursor: pointer;
}

.mobile-toggle .chevron {
    font-size: 14px;
    margin-left: 6px;
}

/* Footer menu (ul) base */
.footer-menu {
    display: block;
    transition: all 0.3s ease;
}

/* Toggle open class */
.footer-menu.open {
    display: block;
}

/* Tablet view refinements */
@media (max-width: 1100px) {
    .content_container {
        flex-wrap: wrap;
    }

    .box_container4 {
        min-width: 220px;
        padding: 0 18px;
    }
}

/* Mobile view enhancements */
@media (max-width: 800px) {
    .content_container {
        flex-direction: column;
        align-items: center;
        border: none;
    }

    .box_container4 {
        border: none;
        border-bottom: 1px solid #e5e5e5;
        width: 100%;
        padding: 18px 0;
        text-align: center;
    }

    .box_container4:last-child {
        border-bottom: none;
    }

    .tittles {
        display: none; /* Hidden on mobile, replaced with toggle */
    }

    .mobile-toggle {
        display: block;
    }

    .footer-menu {
        display: none;
        flex-direction: column;
        align-items: center;
        margin-top: 10px;
    }

    .footer-menu.open {
        display: flex;
    }

    .footer-menu li {
        text-align: center;
    }

    footer {
        text-align: center;
        padding-left: 0;
    }

    footer p {
        margin-left: 0;
    }
}

</style>