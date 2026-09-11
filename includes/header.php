<?php
declare(strict_types=1);
/** @var array $config */
$pageTitle = $pageTitle ?? $config['app_name'];
?>
<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="The Token Supercycle is here. Breakpoint 2026 at Olympia Convention Centre, London, 15–17 November. Free ticket." />
  <meta name="theme-color" content="#0b0712" />
  <link rel="icon" type="image/svg+xml" href="favicon.svg" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@500;600;700;800&family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@400;500;600&display=swap" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style type="text/tailwindcss">
    @theme {
      --color-bg: #0b0712;
      --color-fg: #f4eefe;
      --color-muted: #b5a6c9;
      --color-primary: #b56bff;
      --color-accent: #5dffc2;
      --color-surface: #17101f;
      --color-border: #3d2e52;
      --color-paper: #f3e9d8;
      --color-ink: #110d14;
      --color-hero: #a564f4;
      --color-glitch: #aa67fb;
      --font-display: "Barlow Condensed", "Arial Narrow", sans-serif;
      --font-sans: "IBM Plex Sans", system-ui, sans-serif;
      --font-mono: "IBM Plex Mono", ui-monospace, monospace;
    }
  </style>
  <link rel="stylesheet" href="assets/css/theme.css" />
</head>
<body class="bg-bg text-fg">
