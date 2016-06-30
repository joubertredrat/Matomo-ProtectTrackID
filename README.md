# Piwik ProtectTrackID Plugin

## Description

A Piwik plugin for you protect track ID

## FAQ

__Why isn't good to change salt and lenght more times?__

Because if you change salt, hashed string will change too, then old hashes will not work. ONLY change salt if you will change all JavaScript Tracking Code or Image Tracking Link after. Then is **HIGHT RECOMMENDED to set configurations ONLY ONE TIME**.

__How to I config plugin?__

On Administration > Plugin Settings. For plugin work, is required all configurations defined, if only one or two defined, plugin will not work.

Plugin need 3 configurations, `base string`, `salt` and `lenght`.

`base string` is string used to generate hash. Example, if you set `ABCDEFGHIJKLMNOPQRSTUVXWYZ`, plugin will use only this characters for build hash.

`salt` is a radom string key for generate hash with `base string` and `lenght` configs.

`lenght` is a hash string size. If you set `10` as example, plugin will generete hash with 10 characters defined on `base string`.

__Why JavaScript Tracking Code and Image Tracking Link is blank?__

This plugin will hash siteId by configurations, but if you define small `base string` or `lenght`, plugin can't create hash string. Then you need incresease `base string` and/or `lenght`.

## Changelog

* Version 0.1.1 - Beta version with base string on config
* Version 0.1.0 - First version, alpha

## Support

Want support? Here in https://github.com/joubertredrat/Piwik-ProtectTrackID/issues
