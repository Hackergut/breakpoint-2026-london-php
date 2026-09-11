<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$ticket = !empty($formError) ? null : ($ticket ?? ($_SESSION['ticket'] ?? null));
$formError = $formError ?? null;
$pageTitle = $config['app_name'];

include __DIR__ . '/includes/header.php';
?>
<main class="min-h-dvh bg-bg text-fg">
  <div class="pointer-events-none fixed top-0 left-0 z-50 h-0.5 w-full origin-left bg-primary" data-scroll-progress aria-hidden="true"></div>

  <section class="relative min-h-dvh overflow-hidden bg-hero">
    <div class="bp-glitch-root bp-hero-glitch absolute inset-0 overflow-hidden" data-hero-glitch>
      <img src="media/hero-london.jpg" alt="London skyline — Olympia, Breakpoint 2026" class="absolute inset-0 size-full object-cover object-right" />
    </div>
    <div class="pointer-events-none absolute inset-0 bg-linear-to-r from-ink/80 via-ink/45 to-transparent"></div>
    <div class="pointer-events-none absolute inset-0 bg-linear-to-t from-ink/70 via-ink/20 to-ink/25"></div>

    <header class="absolute inset-x-0 top-4 z-40 flex justify-center px-4">
      <div class="flex w-full max-w-xl items-center justify-between bg-ink px-4 py-2">
        <a href="#register" class="flex min-h-11 items-center gap-2">
          <img src="brand/nav-solana.svg" alt="" class="h-5 w-auto" />
          <img src="brand/nav-bp26.svg" alt="BP26" class="h-5 w-auto" />
        </a>
        <details class="relative">
          <summary class="nav-summary flex size-11 cursor-pointer items-center justify-center text-fg">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 5h16M4 12h16M4 19h16"/></svg>
            <span class="sr-only">Menu</span>
          </summary>
          <nav class="absolute right-0 mt-2 w-48 border border-border bg-ink p-3 font-mono text-xs tracking-widest uppercase">
            <a href="#register" class="block min-h-11 py-3 text-fg">Tickets</a>
            <a href="#week" class="block min-h-11 py-3 text-fg">The week</a>
            <a href="#speakers" class="block min-h-11 py-3 text-fg">Speakers</a>
            <a href="#partners" class="block min-h-11 py-3 text-fg">Sponsors</a>
            <a href="#ecosystem" class="block min-h-11 py-3 text-fg">Community events</a>
          </nav>
        </details>
      </div>
    </header>

    <div class="relative z-20 flex min-h-dvh flex-col justify-end px-5 pb-28 pt-32 sm:px-12 lg:px-16">
      <p class="mb-4 max-w-xl font-mono text-xs tracking-widest text-accent uppercase sm:text-sm">
        <?= encrypt_span('Hacker house · build · deploy · ship more', MATRIX_CHARSET, 'text-accent/50', 'text-accent', 40) ?>
      </p>
      <h1 class="hero-title max-w-4xl text-5xl leading-[0.95] tracking-tight text-fg sm:text-7xl lg:text-8xl">
        <?= encrypt_span('The Token', MATH_CHARSET, 'text-accent', 'text-white', 55, 'block') ?>
        <?= encrypt_span('Supercycle Is Here', MATH_CHARSET, 'text-accent', 'text-white', 55, 'block') ?>
      </h1>
      <a href="#register" class="bp26-button mt-8 inline-flex min-h-11 items-center gap-2 bg-fg px-6 font-mono text-xs tracking-widest text-ink uppercase">
        Register
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 17 17 7M7 7h10v10"/></svg>
      </a>
    </div>

    <p class="absolute bottom-0 left-0 z-10 bg-ink px-5 py-3 font-mono text-xs tracking-widest text-fg uppercase sm:px-8 sm:text-sm">
      <?= encrypt_span('15–17 November 2026', MATH_CHARSET, 'text-primary', 'text-fg', 32) ?>
    </p>
    <a href="https://solana.com" class="absolute right-5 bottom-5 z-10 flex size-14 items-center justify-center rounded-full bg-ink" aria-label="Solana">
      <img src="brand/nav-solana.svg" alt="" class="h-5 w-auto" />
    </a>
  </section>

  <section id="register" class="relative z-30 mx-auto -mt-14 w-full max-w-3xl px-4 sm:-mt-20 sm:max-w-4xl sm:px-8">
    <?php include __DIR__ . '/includes/register-form.php'; ?>
  </section>

  <div class="border-b border-border bg-ink py-4">
    <div class="relative overflow-hidden">
      <div class="marquee-container marquee-fade flex w-full cursor-default overflow-hidden p-2 select-none">
        <div class="marquee-inner flex shrink-0 items-center will-change-transform">
          <?php for ($copy = 0; $copy < 4; $copy++): ?>
            <div class="flex shrink-0 items-center gap-12 pr-12" <?= $copy > 0 ? 'aria-hidden="true"' : '' ?>>
              <?php foreach (TAPE as $item): ?>
                <div class="flex shrink-0 items-center justify-center">
                  <span class="flex items-center gap-12 font-mono text-xl tracking-widest uppercase">
                    <?= encrypt_span($item, MATH_CHARSET, 'text-primary', 'text-fg', 50) ?>
                    <span class="text-primary" aria-hidden="true">/</span>
                  </span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </div>

  <section class="border-b border-border px-4 py-14 sm:px-8">
    <div class="mx-auto max-w-6xl">
      <div class="bp-reveal">
        <p class="font-mono text-[11px] tracking-widest text-primary uppercase">The Token Supercycle</p>
        <h2 class="mt-2 max-w-3xl font-display text-5xl uppercase leading-none">
          <?= encrypt_span('Capital, coordination, and settlement — onchain.') ?>
        </h2>
      </div>
      <p class="mt-6 font-mono text-sm tracking-wide">
        <?= encrypt_span(CIPHER, MATH_CHARSET, 'text-primary', 'text-fg', 40) ?>
      </p>
      <div class="mt-8 space-y-4 text-muted">
        <p>
          Breakpoint 2026 centers on the Token Supercycle: a new era in which stablecoins, tokenized assets,
          payments, and AI-driven economic activity increasingly move onchain. As AI accelerates demand for
          capital, coordination, and real-time settlement, Solana is the battle-tested, always-on
          infrastructure built for the next generation of the global economy.
        </p>
        <p>
          Breakpoint 2026 brings together financial institutions, technology companies, investors, and
          policymakers shaping this supercycle and building the next era of capital markets.
        </p>
      </div>
      <dl class="mt-8 grid grid-cols-2 gap-4 border-t border-border pt-6 text-sm">
        <div>
          <dt class="font-mono text-[10px] tracking-widest text-muted uppercase">Venue</dt>
          <dd>Olympia Convention Centre</dd>
        </div>
        <div>
          <dt class="font-mono text-[10px] tracking-widest text-muted uppercase">Main dates</dt>
          <dd>15–17 November 2026</dd>
        </div>
        <div>
          <dt class="font-mono text-[10px] tracking-widest text-muted uppercase">City</dt>
          <dd>London</dd>
        </div>
        <div>
          <dt class="font-mono text-[10px] tracking-widest text-muted uppercase">Capacity</dt>
          <dd><span class="font-display text-lg" data-ticker="8000" data-locale="1" data-suffix="+">8000+</span></dd>
        </div>
      </dl>
    </div>
  </section>

  <section id="week" class="mx-auto max-w-6xl px-4 py-14 sm:px-8">
    <div class="bp-reveal">
      <p class="font-mono text-[11px] tracking-widest text-muted uppercase">The week</p>
      <h2 class="mt-2 font-display text-5xl uppercase">
        <?= encrypt_span('Three doors. One flight.') ?>
      </h2>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-6 border-y border-border py-6 sm:grid-cols-4">
      <?php
        $stats = [
            ['value' => 3, 'label' => 'Rooms', 'suffix' => '', 'locale' => false],
            ['value' => 12, 'label' => 'House days', 'suffix' => '', 'locale' => false],
            ['value' => 8000, 'label' => 'Capacity', 'suffix' => '+', 'locale' => true],
            ['value' => 200, 'label' => 'Scale latency', 'suffix' => 'ms', 'locale' => false],
        ];
        foreach ($stats as $stat):
      ?>
        <div>
          <p class="font-display text-4xl leading-none text-fg">
            <span class="font-display text-4xl leading-none" data-ticker="<?= (int) $stat['value'] ?>" data-suffix="<?= e($stat['suffix']) ?>" <?= $stat['locale'] ? 'data-locale="1"' : '' ?>><?= e((string) $stat['value'] . $stat['suffix']) ?></span>
          </p>
          <p class="mt-2 font-mono text-[11px] tracking-widest text-muted uppercase"><?= e($stat['label']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="mt-8 grid gap-4 md:grid-cols-3">
      <?php foreach (WEEK as $i => $e): ?>
        <div class="bp-reveal" style="animation-delay: <?= $i * 0.08 ?>s">
          <article class="border border-border bg-surface">
            <div class="bp-glitch-root relative aspect-square w-full overflow-hidden bg-ink" data-glitch="hover">
              <img src="<?= e($e['img']) ?>" alt="<?= e($e['title']) ?>" class="<?= $e['contain'] ? 'size-full object-contain p-4' : 'size-full object-cover' ?>" />
            </div>
            <div class="p-4">
              <p class="font-mono text-[11px] text-accent uppercase"><?= e($e['when']) ?></p>
              <h3 class="font-display text-3xl uppercase"><?= encrypt_span($e['title']) ?></h3>
              <p class="text-sm text-muted"><?= e($e['where']) ?></p>
            </div>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="border-y border-border bg-surface">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-14 sm:grid-cols-2 sm:px-8">
      <div class="bp-reveal">
        <p class="font-mono text-[11px] tracking-widest text-primary uppercase">14 Nov</p>
        <h2 class="mt-2 font-display text-5xl uppercase leading-none"><?= encrypt_span('Scale or Die') ?></h2>
        <p class="mt-4 text-muted">
          The day-before pressure test. Infra, latency, and teams that ship under 200ms. London skyline, no
          filler talks.
        </p>
      </div>
      <div class="bp-reveal" style="animation-delay: 0.1s">
        <div class="bp-glitch-root relative aspect-square w-full overflow-hidden border border-border bg-ink" data-glitch="hover">
          <img src="media/scale-200ms.png" alt="Scale or Die — 200ms" class="size-full object-contain p-6" />
        </div>
      </div>
    </div>
  </section>

  <section class="mx-auto max-w-6xl px-4 py-14 sm:px-8">
    <div class="grid gap-8 lg:grid-cols-2">
      <div class="bp-reveal">
        <div class="bp-glitch-root relative w-full overflow-hidden border border-border bg-ink" data-glitch="hover">
          <img src="media/hacker-house.webp" alt="Hacker House London" class="w-full object-cover" />
        </div>
      </div>
      <div class="bp-reveal" style="animation-delay: 0.08s">
        <p class="font-mono text-[11px] tracking-widest text-accent uppercase">01–12 Nov · Special edition</p>
        <h2 class="mt-2 font-display text-5xl uppercase leading-none"><?= encrypt_span('Hacker House') ?></h2>
        <p class="mt-4 text-muted">
          Twelve days of build rooms before the conference. Bring a laptop. Leave with a demo — and a ticket
          for the rest of the week.
        </p>
      </div>
    </div>
  </section>

  <section class="border-y border-border px-4 py-14 sm:px-8" id="speakers">
    <div class="mx-auto max-w-6xl">
      <div class="bp-reveal">
        <p class="font-mono text-[11px] tracking-widest text-muted uppercase">Speakers</p>
        <h2 class="mt-2 font-display text-5xl uppercase"><?= encrypt_span('On the programme') ?></h2>
      </div>
      <div class="mt-6">
        <p class="max-w-lg text-left text-lg">
          <?= encrypt_span('The people shaping the Token Supercycle — on stage in London.', 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()_+-={}[];:,.<>/?', 'text-muted', 'text-fg', 50) ?>
        </p>
      </div>
      <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach (SPEAKERS as $i => $s): ?>
          <div class="bp-reveal" style="animation-delay: <?= $i * 0.05 ?>s">
            <article class="flex h-full flex-col border border-border bg-surface">
              <div class="bp-glitch-root relative aspect-square w-full overflow-hidden bg-ink" data-glitch="hover">
                <img src="<?= e($s['img']) ?>" alt="<?= e($s['name']) ?>" class="size-full object-cover" />
              </div>
              <div class="flex flex-1 flex-col justify-between p-5">
                <p class="font-mono text-[11px] tracking-widest text-accent uppercase"><?= e($s['org']) ?></p>
                <h3 class="mt-3 font-display text-3xl uppercase leading-none"><?= encrypt_span($s['name']) ?></h3>
                <p class="mt-3 text-sm text-muted"><?= e($s['role']) ?></p>
              </div>
            </article>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  <section id="ecosystem" class="border-y border-border px-4 py-14 sm:px-8">
    <div class="mx-auto max-w-6xl">
      <div class="bp-reveal">
        <p class="font-mono text-[11px] tracking-widest text-primary uppercase">Ecosystem</p>
        <h2 class="mt-2 max-w-3xl font-display text-5xl uppercase leading-none">
          <?= encrypt_span('Explore events across the Breakpoint ecosystem') ?>
        </h2>
      </div>
      <p class="mt-6 max-w-2xl break-all font-mono text-sm leading-relaxed tracking-wide">
        <?= encrypt_span(CIPHER, MATH_CHARSET, 'text-primary', 'text-fg', 32) ?>
      </p>
      <a href="https://luma.com/BP-SideEvents" class="mt-8 inline-flex min-h-11 items-center gap-2 bg-fg px-6 font-mono text-xs tracking-widest text-ink uppercase">
        See community events
        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M7 17 17 7M7 7h10v10"/></svg>
      </a>
    </div>
  </section>

  <section class="overflow-hidden">
    <div class="mx-auto max-w-6xl px-4 pt-14 sm:px-8">
      <div class="bp-reveal">
        <p class="font-mono text-[11px] tracking-widest text-muted uppercase">Floor</p>
        <h2 class="mt-2 font-display text-5xl uppercase"><?= encrypt_span('What the room feels like') ?></h2>
      </div>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-2 md:hidden">
      <?php foreach (SCENES as $s): ?>
        <img src="<?= e($s['src']) ?>" alt="<?= e($s['alt']) ?>" class="aspect-4/3 w-full object-cover" />
      <?php endforeach; ?>
    </div>
    <div class="relative hidden h-pin md:block" data-scroll-strip>
      <div class="sticky top-0 flex h-dvh items-center overflow-hidden">
        <div class="flex gap-4 px-4 sm:px-8" data-scroll-strip-row>
          <?php foreach (SCENES as $s): ?>
            <figure class="min-w-80 shrink-0">
              <img src="<?= e($s['src']) ?>" alt="<?= e($s['alt']) ?>" class="aspect-4/3 w-full object-cover" />
              <figcaption class="mt-2 font-mono text-[11px] tracking-widest text-muted uppercase"><?= e($s['alt']) ?></figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <section id="partners" class="border-t border-border bg-ink py-12">
    <p class="px-4 text-center font-mono text-xs tracking-widest text-muted uppercase sm:px-8">
      <?= encrypt_span('Partners', MATH_CHARSET, 'text-muted', 'text-fg', 70) ?>
    </p>
    <div class="mt-8">
      <div class="relative overflow-hidden">
        <div class="marquee-container marquee-fade marquee-pause flex w-full overflow-hidden p-2 select-none">
          <div class="marquee-inner flex shrink-0 items-center will-change-transform">
            <?php for ($copy = 0; $copy < 4; $copy++): ?>
              <div class="flex shrink-0 items-center gap-12 pr-12" <?= $copy > 0 ? 'aria-hidden="true"' : '' ?>>
                <?php foreach (PARTNERS as $p): ?>
                  <div class="flex shrink-0 items-center justify-center">
                    <img src="<?= e($p['src']) ?>" alt="<?= e($p['alt']) ?>" class="h-10 w-auto max-w-56 object-contain" />
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-6 relative overflow-hidden">
      <div class="marquee-container marquee-fade flex w-full overflow-hidden p-2 select-none">
        <div class="marquee-inner-reverse flex shrink-0 items-center will-change-transform">
          <?php $rev = array_reverse(PARTNERS); for ($copy = 0; $copy < 4; $copy++): ?>
            <div class="flex shrink-0 items-center gap-12 pr-12" aria-hidden="true">
              <?php foreach ($rev as $p): ?>
                <div class="flex shrink-0 items-center justify-center">
                  <img src="<?= e($p['src']) ?>" alt="" class="h-8 w-auto max-w-52 object-contain opacity-70" />
                </div>
              <?php endforeach; ?>
            </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>
  </section>

  <div class="pt-20 md:pt-[120px]">
    <div class="h-[50px] w-full overflow-hidden">
      <svg aria-hidden="true" viewBox="0 0 1440 200" preserveAspectRatio="none" class="block h-[50px] w-full min-w-[840px] text-hero">
        <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd" d="M1440 23.1202V200H0V14.114H91.5512V1.12952H351.685V14.114H524.223V21.1111H704.724V13.1145H818.864V0.629734L992.729 0.309869L1166.59 0V14.124H1222.34V23.1202H1440Z" />
      </svg>
    </div>
    <footer class="bg-hero text-ink">
      <div class="flex flex-col items-start justify-between gap-8 px-4 py-8 sm:px-8 md:flex-row md:items-center">
        <nav class="flex items-center gap-4" aria-label="Social">
          <a href="https://x.com/solana" class="flex size-6 items-center justify-center opacity-90 hover:opacity-70" aria-label="X"><img src="brand/icon-x.svg" alt="" class="h-5 w-5" /></a>
          <a href="https://www.youtube.com/@SolanaFndn" class="flex size-6 items-center justify-center opacity-90 hover:opacity-70" aria-label="YouTube"><img src="brand/icon-youtube.svg" alt="" class="h-5 w-5" /></a>
          <a href="https://discord.com/invite/solana" class="flex size-6 items-center justify-center opacity-90 hover:opacity-70" aria-label="Discord"><img src="brand/icon-discord.svg" alt="" class="h-5 w-5" /></a>
          <a href="https://github.com/solana-foundation" class="flex size-6 items-center justify-center opacity-90 hover:opacity-70" aria-label="GitHub"><img src="brand/icon-github.svg" alt="" class="h-5 w-5" /></a>
          <a href="https://www.reddit.com/r/solana" class="flex size-6 items-center justify-center opacity-90 hover:opacity-70" aria-label="Reddit"><img src="brand/icon-reddit.svg" alt="" class="h-5 w-5" /></a>
        </nav>
        <p class="font-mono text-xs tracking-widest uppercase">© 2026 Solana Foundation</p>
        <div class="flex flex-col items-start gap-4 md:flex-row md:items-center md:gap-8">
          <a href="mailto:breakpoint@solana.org" class="font-mono text-xs tracking-widest uppercase hover:opacity-70">Contact →</a>
          <a href="https://solana.com/community/code-of-conduct" class="font-mono text-xs tracking-widest uppercase hover:opacity-70">Code of conduct →</a>
        </div>
      </div>
      <div class="px-4 py-8 sm:px-8">
        <div class="grid grid-cols-2 gap-x-6 gap-y-6 md:flex md:items-center md:justify-between" data-countdown="2026-11-15T09:00:00+00:00">
          <div class="flex min-w-0 flex-1 flex-col items-start justify-center text-left uppercase md:items-center md:text-center">
            <p class="font-display text-5xl leading-none tracking-wide md:text-7xl" data-cd="days">000</p>
            <p class="mt-2 font-mono text-[11px] tracking-widest">Days</p>
          </div>
          <div class="flex min-w-0 flex-1 flex-col items-start justify-center text-left uppercase md:items-center md:text-center">
            <p class="font-display text-5xl leading-none tracking-wide md:text-7xl" data-cd="hours">00</p>
            <p class="mt-2 font-mono text-[11px] tracking-widest">Hours</p>
          </div>
          <div class="flex min-w-0 flex-1 flex-col items-start justify-center text-left uppercase md:items-center md:text-center">
            <p class="font-display text-5xl leading-none tracking-wide md:text-7xl" data-cd="minutes">00</p>
            <p class="mt-2 font-mono text-[11px] tracking-widest">Minutes</p>
          </div>
          <div class="flex min-w-0 flex-1 flex-col items-start justify-center text-left uppercase md:items-center md:text-center">
            <p class="font-display text-5xl leading-none tracking-wide md:text-7xl" data-cd="seconds">00</p>
            <p class="mt-2 font-mono text-[11px] tracking-widest">Seconds</p>
          </div>
        </div>
      </div>
      <div class="flex w-full items-center justify-center px-4 pb-10 sm:px-8">
        <img src="brand/bp26-footer-logo-mobile.svg" alt="Solana Breakpoint 2026" class="h-auto w-full md:hidden" />
        <img src="brand/breakpoint-footer-logo-desktop.svg" alt="Solana Breakpoint 2026" class="hidden h-auto w-full md:block" />
      </div>
    </footer>
  </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
