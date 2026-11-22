# Deploys an approved release to local staging. Use the SAME script to roll back
# (pass the known-good version and its digests).
param(
  [Parameter(Mandatory)][string]$Version,
  [Parameter(Mandatory)][string]$AppDigest,
  [Parameter(Mandatory)][string]$WebDigest,
  [string]$Owner = 'jl1502',
  [int]$Port = 8080,
  [switch]$Migrate
)
$ErrorActionPreference = 'Stop'
if (-not (Test-Path .env.staging)) { throw '.env.staging is missing. Copy .env.staging.example and fill it in.' }

$env:APP_VERSION = $Version
$env:APP_IMAGE   = "ghcr.io/$Owner/laravel-staging-app@$AppDigest"
$env:WEB_IMAGE   = "ghcr.io/$Owner/laravel-staging-web@$WebDigest"
$env:WEB_PORT    = $Port
$f = 'compose.staging.yaml'

docker compose -f $f pull
docker compose -f $f up -d

if ($Migrate) { docker compose -f $f exec -T app php artisan migrate --force }
docker compose -f $f exec -T app php artisan migrate:status

$ok = $false
for ($i = 0; $i -lt 30 -and -not $ok; $i++) {
  try {
    $h = Invoke-RestMethod "http://127.0.0.1:$Port/health"
    if ($h.status -eq 'ok' -and $h.version -eq $Version) { $ok = $true }
  } catch { }
  if (-not $ok) { Start-Sleep -Seconds 3 }
}
$state = if ($ok) { 'HEALTH OK' } else { 'HEALTH FAILED' }
"$(Get-Date -Format s) deploy $Version app=$AppDigest $state" | Add-Content deploy-log.txt
Write-Host "$state (running version: $($h.version))"
if (-not $ok) { exit 1 }
