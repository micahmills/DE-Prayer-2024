.po and .mo files must be in this format:
{translation-domain}-{localisation}.po

ex:
de-prayer-2024-fr_FR.po

Use the locale codes selected by Prayer Campaigns, which become the WordPress
locale on campaign pages:

- Simplified Chinese: `zh_Hans` (not `zh_CN`)
- Traditional Chinese: `zh_Hant` (not `zh_TW`)
- Korean: `ko_KR`

For example, `?lang=zh_Hans` loads `de-prayer-2024-zh_Hans.mo`.
After editing a PO file, rebuild its MO file with `wp i18n make-mo languages`.
Include both the PO and MO files when deploying translations.
