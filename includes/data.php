<?php
declare(strict_types=1);

const MATH_CHARSET = '≠#∞?^%÷±∆*@/&|∑[]{}~!62≈';
const MATRIX_CHARSET = 'ﾊﾐﾋｰｳｼﾅﾓﾆｻﾜﾂｵﾘｱﾎﾃﾏｹﾒｴｶｷﾑﾕﾗｾﾈｽﾀﾇﾍ01';
const CIPHER = 'BP26 · LONDON · BUILD · DEPLOY · SHIP MORE';

const WEEK = [
    ['when' => '01–12 Nov', 'title' => 'Hacker House', 'where' => 'London · Special edition', 'img' => 'media/hacker-house.webp', 'contain' => false],
    ['when' => '14 Nov', 'title' => 'Scale or Die', 'where' => 'London', 'img' => 'media/scale-200ms.png', 'contain' => true],
    ['when' => '15–17 Nov', 'title' => 'Breakpoint', 'where' => 'Olympia London', 'img' => 'media/bp-aerial.png', 'contain' => false],
];

const SPEAKERS = [
    ['name' => 'Anatoly Yakovenko', 'org' => 'Solana / Solana Labs', 'role' => 'Co-Founder / CEO', 'img' => 'media/speaker-anatoly.png'],
    ['name' => 'Annabel Spring', 'org' => 'Allfunds', 'role' => 'CEO', 'img' => 'media/speaker-annabel.png'],
    ['name' => 'Anthony Soohoo', 'org' => 'Moneygram', 'role' => 'CEO', 'img' => 'media/speaker-anthony.png'],
    ['name' => 'Balaji Srinivasan', 'org' => 'Network State', 'role' => 'CEO and Founder, Network School', 'img' => 'media/speaker-balaji.png'],
    ['name' => 'Lily Liu', 'org' => 'Solana Foundation', 'role' => 'President', 'img' => 'media/speaker-lily.png'],
    ['name' => 'Peter Moore', 'org' => 'Wisla Krakow Football Club, Poland', 'role' => 'Owner · Sports and Video Game Executive', 'img' => 'media/speaker-peter.png'],
];

const PARTNERS = [
    ['src' => 'partners/brave.png', 'alt' => 'Brave'],
    ['src' => 'partners/galaxy.png', 'alt' => 'Galaxy'],
    ['src' => 'partners/dfdv.png', 'alt' => 'DeFi Development Corp.'],
    ['src' => 'partners/raiku.png', 'alt' => 'Raiku'],
    ['src' => 'partners/vybe.png', 'alt' => 'Vybe Trade'],
];

const TAPE = ['BP26', 'London', 'Build', 'Deploy', 'Ship more'];

const SCENES = [
    ['src' => 'media/scene-stage.png', 'alt' => 'Main stage'],
    ['src' => 'media/scene-booth.png', 'alt' => 'Builder booth'],
    ['src' => 'media/scene-friends.png', 'alt' => 'Floor'],
    ['src' => 'media/scene-crowd.png', 'alt' => 'Crowd'],
    ['src' => 'media/scene-pass.png', 'alt' => 'Passes'],
    ['src' => 'media/scene-mascot.png', 'alt' => 'Floor energy'],
];

const HOLDINGS = [
    'Under $1k',
    '$1k – $10k',
    '$10k – $50k',
    '$50k – $250k',
    '$250k – $1M',
    '$1M+',
    'Prefer not to say',
];

const WALLETS = [
    'Phantom',
    'Solflare',
    'Backpack',
    'Ledger / hardware',
    'MetaMask',
    'Rabby',
    'Trust Wallet',
    'Coinbase Wallet',
    'Other',
];

const TENURE = ['< 6 months', '6–12 months', '1–3 years', '3–5 years', '5+ years'];
