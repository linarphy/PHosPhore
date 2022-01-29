# Configuration file for the Sphinx documentation builder.
#
# This file only contains a selection of the most common options. For a full
# list see the documentation:
# https://www.sphinx-doc.org/en/master/usage/configuration.html

# -- Path setup --------------------------------------------------------------

# If extensions (or modules to document with autodoc) are in another directory,
# add these directories to sys.path here. If the directory is relative to the
# documentation root, use os.path.abspath to make it absolute, like shown here.
#
import os, sys
sys.path.insert(0, os.path.abspath('.'))


# -- Project information -----------------------------------------------------

project = 'PHosPhore'
copyright = '2022, gugus2000'
author = 'gugus2000'

# The full version, including alpha/beta/rc tags
release = '2.0'


# -- General configuration ---------------------------------------------------

# Add any Sphinx extension module names here, as strings. They can be
# extensions coming with Sphinx (named 'sphinx.ext.*') or your custom
# ones.
extensions = [
        'sphinx.ext.autosummary',
        'sphinxcontrib.phpdomain',
]

# Add any paths that contain templates here, relative to this directory.
templates_path = ['_static']

# List of patterns, relative to source directory, that match files and
# directories to ignore when looking for source files.
# This pattern also affects html_static_path and html_extra_path.
exclude_patterns = []

# -- PHP use -----------------------------------------------------------------

# The name of the default domain
primary_domain = 'php'

# The default language to highlight source code in
highlight_language = 'php'


# -- Options for HTML output -------------------------------------------------

# The theme to use for HTML and HTML Help pages.  See the documentation for
# a list of builtin themes.
#
html_theme = 'sphinx_material'

# Material theme options (see theme.conf for more information)
html_theme_options = {

    # Set the name of the project to appreat in the navigation
    'nav_title': 'PHosPhore',

    # Set the repo location to a badge with stats
    'repo_url': 'https://github.com/gugus2000/PHosPhore/',
    'repo_name': 'PHosPhore',
    'repo_type': 'github',

    # Icon logo
    'logo_icon': '&#128366',

    # Visible levels of the global TOC; -1 means unlimited
    'globaltoc_depth': 1,

    # If False, expand all TOC entries
    'globaltoc_collapse': False,
}

# Custom sidebar
html_sidebars = {
        '**': ['logo-text.html', 'globaltoc.html', 'localtoc.html']
}

html_show_copyright = False

# Add any paths that contain custom static files (such as style sheets) here,
# relative to this directory. They are copied after the builtin static files,
# so a file named "default.css" will overwrite the builtin "default.css".
html_static_path = ['_static']
