<?php
declare(strict_types=1);
/** @var ?array $ticket */
/** @var ?string $formError */
$field = 'mt-2 w-full border-2 border-ink bg-accent px-4 py-4 text-lg font-semibold text-ink caret-ink outline-none placeholder:font-medium placeholder:text-ink/40 focus:border-ink focus:bg-ink focus:text-accent focus:placeholder:text-accent/50';
?>
<?php if ($ticket): ?>
  <div class="border-2 border-ink bg-accent p-8 text-ink sm:p-10">
    <p class="font-mono text-sm font-bold tracking-widest uppercase">Ticket reserved</p>
    <h3 class="mt-3 font-display text-6xl font-extrabold uppercase leading-none">
      <?= encrypt_span("You're in", MATH_CHARSET, 'text-ink/40', 'text-ink', 80) ?>
    </h3>
    <p class="mt-4 text-base font-semibold text-ink/80">Screenshot this stub. Same copy is stored on this server.</p>
    <dl class="mt-6 space-y-1.5 font-mono text-sm font-bold leading-7">
      <div>ID <?= e($ticket['id']) ?></div>
      <div>NAME <?= e($ticket['name']) ?></div>
      <div>EMAIL <?= e($ticket['email']) ?></div>
      <div>PHONE <?= e($ticket['phone']) ?></div>
      <div>FROM <?= e($ticket['from']) ?></div>
      <div>IN CRYPTO <?= e($ticket['tenure']) ?></div>
      <div>HOLDINGS <?= e($ticket['holdings']) ?></div>
      <div>WALLET <?= e($ticket['wallet']) ?></div>
      <div class="pt-3 font-extrabold">HACKER HOUSE · SCALE OR DIE · BREAKPOINT</div>
    </dl>
  </div>
<?php else: ?>
  <form id="register" action="register.php" method="post" class="border-2 border-ink bg-accent p-6 text-ink sm:p-9">
    <div class="mb-7 flex items-end justify-between border-b-4 border-ink pb-4">
      <h2 class="font-display text-5xl font-extrabold uppercase leading-none tracking-tight sm:text-6xl">
        <?= encrypt_span('Register', MATH_CHARSET, 'text-ink/40', 'text-ink', 80) ?>
      </h2>
      <span class="bg-ink px-3 py-1.5 font-mono text-xs font-bold tracking-widest text-accent uppercase">Comp</span>
    </div>
    <input type="hidden" name="fi-text-event" value="Solana London Week 2026" />
    <div class="grid gap-5 sm:grid-cols-2">
      <label class="font-mono text-xs font-bold tracking-widest text-ink uppercase sm:col-span-2">
        Full name
        <input class="<?= $field ?>" name="fi-sender-fullName" autocomplete="name" required placeholder="James Carter" value="<?= e($_POST['fi-sender-fullName'] ?? '') ?>" />
      </label>
      <label class="font-mono text-xs font-bold tracking-widest text-ink uppercase">
        Email
        <input class="<?= $field ?>" name="fi-sender-email" type="email" autocomplete="email" required placeholder="james@mail.com" value="<?= e($_POST['fi-sender-email'] ?? '') ?>" />
      </label>
      <label class="font-mono text-xs font-bold tracking-widest text-ink uppercase">
        Phone number
        <input class="<?= $field ?>" name="fi-sender-phone" type="tel" autocomplete="tel" inputmode="tel" required placeholder="+44 7700 900123" value="<?= e($_POST['fi-sender-phone'] ?? '') ?>" />
      </label>
      <label class="font-mono text-xs font-bold tracking-widest text-ink uppercase sm:col-span-2">
        City or country attending from
        <input class="<?= $field ?>" name="fi-sender-city" autocomplete="address-level2" required placeholder="London / New York / Berlin" value="<?= e($_POST['fi-sender-city'] ?? '') ?>" />
      </label>
      <label class="font-mono text-xs font-bold tracking-widest text-ink uppercase">
        How long in crypto
        <select class="<?= $field ?>" name="fi-select-tenure" required>
          <option value="" disabled <?= empty($_POST['fi-select-tenure']) ? 'selected' : '' ?>>Select</option>
          <?php foreach (TENURE as $t): ?>
            <option value="<?= e($t) ?>" <?= (($_POST['fi-select-tenure'] ?? '') === $t) ? 'selected' : '' ?>><?= e($t) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="font-mono text-xs font-bold tracking-widest text-ink uppercase">
        Holdings range
        <select class="<?= $field ?>" name="fi-select-holdings" required>
          <option value="" disabled <?= empty($_POST['fi-select-holdings']) ? 'selected' : '' ?>>Select</option>
          <?php foreach (HOLDINGS as $t): ?>
            <option value="<?= e($t) ?>" <?= (($_POST['fi-select-holdings'] ?? '') === $t) ? 'selected' : '' ?>><?= e($t) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label class="font-mono text-xs font-bold tracking-widest text-ink uppercase sm:col-span-2">
        Wallet you use the most
        <select class="<?= $field ?>" name="fi-select-wallet" required>
          <option value="" disabled <?= empty($_POST['fi-select-wallet']) ? 'selected' : '' ?>>Select</option>
          <?php foreach (WALLETS as $t): ?>
            <option value="<?= e($t) ?>" <?= (($_POST['fi-select-wallet'] ?? '') === $t) ? 'selected' : '' ?>><?= e($t) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
    </div>
    <p class="mt-5 text-base font-semibold text-ink/80">
      Used to issue your ticket and seat similar profiles. Not sold. Not KYC. Phone with country code.
    </p>
    <?php if (!empty($formError)): ?>
      <p class="mt-4 border-2 border-ink bg-ink px-4 py-3 font-mono text-sm font-bold text-accent" role="alert"><?= e($formError) ?></p>
    <?php endif; ?>
    <div class="bp-glitch-root bp-glitch-sm relative mt-6 block w-full overflow-hidden" data-glitch="hover">
      <button type="submit" class="w-full bg-ink py-5 font-mono text-sm font-bold tracking-widest text-accent uppercase hover:bg-bg hover:text-accent">
        Register — free ticket
      </button>
    </div>
  </form>
<?php endif; ?>
