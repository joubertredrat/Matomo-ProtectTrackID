# Matomo ProtectTrackID Plugin

## Description

Provides a option to protect idSite using hash instead default numeric. This plugin was formerly Piwik Protect TrackID.

## FAQ

__Why isn't good to change configuration more times?__

Because if you change configurations (`base string`, `salt` and `length`), hashed string will change too, then old hashes will not work. ONLY change salt if you will change all JavaScript Tracking Code or Image Tracking Link after change configuration. Then is **HIGHT RECOMMENDED to set configurations ONLY ONE TIME**.

__How to I config plugin?__

On Administration > Plugin Settings. For plugin work, is required all configurations defined, if only one or two defined, plugin will not work.

Plugin need 3 configurations, `base string`, `salt` and `length`.

`base string` is string used to generate hash. Example, if you set `ABCDEFGHIJKLMNOPQRSTUVXWYZ`, plugin will use only this characters for build hash.

`salt` is a radom string key for generate hash with `base string` and `length` configurations.

`length` is a hash string size. If you set `10` as example, plugin will generete hash with 10 characters defined on `base string`.

__Why JavaScript Tracking Code and Image Tracking Link is blank?__

This plugin will hash siteId by configurations, but if you define small `base string`, `salt` or `length`, plugin wont haven't combinations enough for create hash string. Then you need incresease `base string`, `salt` and/or `length`.

__If I install this plugin I need to change track code for all sites or old track code still will work?__ Thanks [@yurgon](https://github.com/yurgon) for the question.

You can install and set plugin configuration, old tracking code will work without problems because plugin validates tracking `siteId` with plugin settings to set if `siteId` is hashed id or normal numeric id. But is necessary attention, because although old tracking code will continue work, Matomo will display only new tracking code.


## Changelog

See [releases](https://github.com/joubertredrat/Matomo-ProtectTrackID/releases). This project follows the guidelines of [semantic versioning](http://semver.org).

## Support

Want support? Check our issues in https://github.com/joubertredrat/Matomo-ProtectTrackID/issues
