# Upgrading

## 6.x

### Breaking changes

- **`isMac()` no longer returns `true` for iOS or iPadOS.** A new `isiOS()`
  method now handles iOS and iPadOS detection separately. If your code uses
  `isMac()` to target both macOS and iOS, update it to check
  `isMac() || isiOS()`.
- **`deviceType()` returns new values.** Previously unknown device types
  defaulted to `Desktop`. Now `TV`, `Console`, and `Wearable` are returned
  when detected. If you switch on `deviceType()`, add cases for these.

### New features

#### Browser detection

- `isBrave()` — Brave browser
- `isVivaldi()` — Vivaldi browser
- `isSamsungBrowser()` — Samsung Internet
- `isArc()` — Arc browser
- `isDuckDuckGo()` — DuckDuckGo Privacy Browser

#### OS detection

- `isiOS()` — iOS (previously covered by `isMac()`)
- `isChromeOS()` — Chrome OS
- `isHarmonyOS()` — HarmonyOS

#### Device type detection

- `isTV()` — Smart TVs, set-top boxes
- `isConsole()` — Game consoles
- `isWearable()` — Smartwatches, headsets

#### In-app browser detection

`isInApp()` now detects: Facebook, Instagram, TikTok, Snapchat, LinkedIn,
Telegram, Line, and Pinterest (in addition to existing WebView, Twitter,
and WeChat detection).
