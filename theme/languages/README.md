# SOP: Handling Translations with PO/POT/MO Files

This SOP document guides you through handling translations using PO, POT, and MO files. It is intended for developers, translators, and anyone involved in the translation process.

## 1. Understanding Translations with PO/POT/MO Files
---------------------------------------------------

-   POT files (Portable Object Template) are the template files for PO files. They contain the original strings.
-   PO files (Portable Object) are text files used in the translation process.
-   MO files (Machine Object) are binary files that are read and used by the gettext function.

## 1. Software Used for Translations
----------------------------------

We use PoEdit, a cross-platform software for editing PO and POT files. It is user-friendly and simplifies the translation process. Visit [PoEdit](https://poedit.net/) for installation instructions.

## 1. Our Workflow
-----------------------------

The POT file is our absolute source of truth. To ensure consistency, always refresh PO files from POT files, not directly from the source code.

### Step 1: Generate or Refresh the POT File

The POT file contains the original strings for translation. Run the terminal command `composer run i18n-make-pot` to create or update the POT file.

### Step 2: Generate or Refresh a PO File from the POT File

The PO file contains the translations. Generate or refresh a PO file in the desired language from the POT file. Remember to use PoEdit for this step.

### Step 3: Translate as Desired

Translate the strings in the PO file using PoEdit. Always save your work to avoid losing any translations.

### Step 4: Generate Translation-json Files

The translation-json files store the translated strings. Generate these files by running the terminal command `composer run i18n-make-json`.

## 1. Troubleshooting
-------------------

If you encounter any issues during the translation process, try restarting the software and repeating the process. If the problem persists, reach out to your supervisor or team leader.
