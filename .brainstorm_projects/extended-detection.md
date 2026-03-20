# Extended Browser, OS, Device & In-App Detection

## Goal

Surface more detection capabilities that matomo/device-detector already provides, and
extend in-app browser detection to cover the most common social/messaging apps.

## Current state

- **Browsers:** Chrome, Firefox, Opera, Safari, Edge, IE
- **OS:** Windows, Linux, Mac (incl. iOS), Android
- **Device types:** Mobile, Tablet, Desktop, Bot
- **In-app:** WebView, Twitter, WeChat, Apple in-app, Android WebView

## Proposed additions

### 1. Browser shortcuts (low effort)

matomo/device-detector already returns the browser family name. The `BrowserDetect` stage
just needs more `elseif` branches + new boolean properties on `Result`.

| Method | Match on `browserFamily` |
|---|---|
| `isBrave()` | `Brave` |
| `isVivaldi()` | `Vivaldi` |
| `isSamsungBrowser()` | `Samsung Internet` |
| `isArc()` | `Arc` |
| `isDuckDuckGo()` | `DuckDuckGo Privacy Browser` |

### 2. OS shortcuts (low effort)

Same approach — match on `platformFamily`.

| Method | Match on `platformFamily` |
|---|---|
| `isChromeOS()` | `Chrome OS` |
| `isHarmonyOS()` | `HarmonyOS` |
| `isiOS()` | `iOS` (currently lumped into `isMac`) |

> Note: `isiOS()` is a breaking-ish change since `isMac()` currently returns true for iOS.
> Consider keeping `isMac()` as-is for backwards compat and adding `isiOS()` alongside it.

### 3. Device type expansion (medium effort)

matomo/device-detector returns device types like `tv`, `console`, `wearable`,
`smart speaker`, `car browser`, `smart display`, `camera`, `portable media player`,
`peripheral`. Currently anything that isn't `desktop`, `tablet`, or `smartphone`/
`feature phone`/`phablet` falls through and defaults to Desktop.

| Method | Device types mapped |
|---|---|
| `isTV()` | `tv` |
| `isConsole()` | `console` |
| `isWearable()` | `wearable` |

Also update `deviceType()` to return these new types instead of always falling back
to `Desktop`.

### 4. In-app browser detection (medium effort)

Extend `detectIsInApp()` with user-agent substring checks for popular apps:

| App | UA substring |
|---|---|
| Facebook | `FBAN` or `FBAV` |
| Instagram | `Instagram` |
| TikTok | `BytedanceWebview` or `musical_ly` |
| Snapchat | `Snapchat` |
| LinkedIn | `LinkedInApp` |
| Telegram | `TelegramBot` or `Telegram` |
| Line | `Line/` |
| Pinterest | `Pinterest` |

## Implementation order

1. **In-app detection** — standalone change in `BrowserDetect::detectIsInApp()`, no new
   properties needed, just better matching. Quick win.
2. **Browser shortcuts** — add properties to `Result`, interface methods to
   `ResultInterface`, detection in `BrowserDetect` stage. Tests per browser.
3. **OS shortcuts** — same pattern. Decide on `isiOS()` vs `isMac()` overlap.
4. **Device types** — update `DeviceDetector` stage mapping, add properties, update
   `deviceType()` return values. This changes existing behavior (unknown devices
   currently default to Desktop), so it needs careful testing.

## Files to touch

- `src/Contracts/ResultInterface.php` — new method signatures
- `src/Result.php` — new properties + methods
- `src/Stages/BrowserDetect.php` — browser/OS matching + in-app detection
- `src/Stages/DeviceDetector.php` — device type mapping
- `tests/` — new test cases for each addition
- `README.md` — update API reference table

## Open questions

- Should `isMac()` stop returning `true` for iOS once `isiOS()` exists? (breaking change)
- Should device types like TV/Console/Wearable get their own Blade directives?
- Should `isInApp()` expose _which_ app (e.g. `inAppName()`), or just remain boolean?
