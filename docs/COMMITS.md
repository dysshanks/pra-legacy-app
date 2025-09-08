
## Initial commit
- **Commit:** `1244f1b7e9b7e8228e4f7f7d0a2a7a88cd7977b5`
- **Date:** 2025-09-08 09:33:05 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 1244f1b7e9b7e8228e4f7f7d0a2a7a88cd7977b5
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Mon Sep 8 09:33:05 2025 +0200
```

<details><summary>Full changes</summary>

```diff
commit 1244f1b7e9b7e8228e4f7f7d0a2a7a88cd7977b5
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Mon Sep 8 09:33:05 2025 +0200

    Initial commit

diff --git a/.editorconfig b/.editorconfig
new file mode 100644
index 0000000..86199ac
--- /dev/null
+++ b/.editorconfig
@@ -0,0 +1,9 @@
+root = true
+
+[*]
+charset = utf-8
+end_of_line = lf
+indent_style = tab
+insert_final_newline = true
+tab_width = 2
+trim_trailing_whitespace = true
\ No newline at end of file
diff --git a/.github/workflows/commit-log.yml b/.github/workflows/commit-log.yml
new file mode 100644
index 0000000..ab27135
--- /dev/null
+++ b/.github/workflows/commit-log.yml
@@ -0,0 +1,79 @@
+name: Log Commits to Markdown
+
+on:
+  push:
+    branches:
+      - main
+
+permissions:
+  contents: write
+
+jobs:
+  log-commits:
+    if: github.actor != 'github-actions[bot]'
+    runs-on: ubuntu-latest
+
+    steps:
+      - name: Checkout repository
+        uses: actions/checkout@v3
+        with:
+          fetch-depth: 0
+          token: ${{ secrets.GITHUB_TOKEN }}
+
+      - name: Gather commit info
+        run: |
+          mkdir -p docs
+          LOG_FILE=docs/COMMITS.md
+          TEMP_FILE=commits_tmp.md
+
+          echo "" > $TEMP_FILE
+
+          if [ "${{ github.event.before }}" = "0000000000000000000000000000000000000000" ]; then
+            RANGE=${{ github.sha }}
+          else
+            RANGE=${{ github.event.before }}..${{ github.sha }}
+          fi
+
+          for commit in $(git rev-list $RANGE); do
+            AUTHOR=$(git log -1 --pretty=format:"%an" $commit)
+            DATE=$(git log -1 --pretty=format:"%ad" --date=iso $commit)
+            TITLE=$(git log -1 --pretty=format:"%s" $commit)
+
+            echo "## $TITLE" >> $TEMP_FILE
+            echo "- **Commit:** \`$commit\`" >> $TEMP_FILE
+            echo "- **Date:** $DATE" >> $TEMP_FILE
+            echo "- **Author:** $AUTHOR" >> $TEMP_FILE
+            echo "" >> $TEMP_FILE
+
+            echo "### Preview (first 3 lines of changes)" >> $TEMP_FILE
+            echo '```diff' >> $TEMP_FILE
+            git show --no-color $commit | head -n 3 >> $TEMP_FILE
+            echo '```' >> $TEMP_FILE
+            echo "" >> $TEMP_FILE
+
+            echo "<details><summary>Full changes</summary>" >> $TEMP_FILE
+            echo "" >> $TEMP_FILE
+            echo '```diff' >> $TEMP_FILE
+            git show --no-color $commit >> $TEMP_FILE
+            echo '```' >> $TEMP_FILE
+            echo "" >> $TEMP_FILE
+            echo "</details>" >> $TEMP_FILE
+            echo "" >> $TEMP_FILE
+          done
+
+          if [ -f "$LOG_FILE" ]; then
+            cat $LOG_FILE >> $TEMP_FILE
+          fi
+          mv $TEMP_FILE $LOG_FILE
+
+      - name: Commit and push log
+        run: |
+          git config user.name "github-actions[bot]"
+          git config user.email "github-actions[bot]@users.noreply.github.com"
+          git add docs/COMMITS.md
+          if git diff --cached --quiet; then
+            echo "No changes to commit"
+          else
+            git commit -m "Update commit log [skip ci]"
+            git push
+          fi
diff --git a/.github/workflows/readme.yml b/.github/workflows/readme.yml
new file mode 100644
index 0000000..47e0067
--- /dev/null
+++ b/.github/workflows/readme.yml
@@ -0,0 +1,51 @@
+name: Generate README
+
+on:
+  push:
+    branches: [ main ]
+  workflow_dispatch:
+
+permissions:
+  contents: write
+
+jobs:
+  generate-readme:
+    runs-on: ubuntu-latest
+    steps:
+      - uses: actions/checkout@v3
+
+      - name: Get repository name
+        id: repo
+        run: echo "repo_name=${GITHUB_REPOSITORY##*/}" >> "$GITHUB_OUTPUT"
+
+      - name: Check if README exists
+        id: check_readme
+        run: |
+          if [ -f README.md ]; then
+            echo "exists=true" >> "$GITHUB_OUTPUT"
+          else
+            echo "exists=false" >> "$GITHUB_OUTPUT"
+          fi
+
+      - name: Generate README
+        if: ${{ steps.check_readme.outputs.exists == 'false' }}
+        run: |
+          echo "# ${{ steps.repo.outputs.repo_name }}" > README.md
+          echo "" >> README.md
+          echo "![Build](https://github.com/${{ github.repository }}/actions/workflows/readme-generator.yml/badge.svg)" >> README.md
+          echo "![Issues](https://img.shields.io/github/issues/${{ github.repository }})" >> README.md
+          echo "![Stars](https://img.shields.io/github/stars/${{ github.repository }})" >> README.md
+          echo "![License](https://img.shields.io/github/license/${{ github.repository }})" >> README.md
+          echo "" >> README.md
+          echo "---" >> README.md
+          echo "*This README was auto-generated.*" >> README.md
+
+      - name: Commit and push README
+        if: ${{ steps.check_readme.outputs.exists == 'false' }}
+        run: |
+          git config --global user.name "github-actions[bot]"
+          git config --global user.email "github-actions[bot]@users.noreply.github.com"
+          git pull --rebase origin main
+          git add README.md
+          git commit -m "Auto-generate README.md"
+          git push
\ No newline at end of file
diff --git a/.gitignore b/.gitignore
new file mode 100644
index 0000000..5c4eb8c
--- /dev/null
+++ b/.gitignore
@@ -0,0 +1,667 @@
+## Ignore Visual Studio temporary files, build results, and
+## files generated by popular Visual Studio add-ons.
+##
+## Get latest from https://github.com/github/gitignore/blob/main/VisualStudio.gitignore
+
+# User-specific files
+*.rsuser
+*.suo
+*.user
+*.userosscache
+*.sln.docstates
+*.env
+
+# User-specific files (MonoDevelop/Xamarin Studio)
+*.userprefs
+
+# Mono auto generated files
+mono_crash.*
+
+# Build results
+[Dd]ebug/
+[Dd]ebugPublic/
+[Rr]elease/
+[Rr]eleases/
+x64/
+x86/
+[Ww][Ii][Nn]32/
+[Aa][Rr][Mm]/
+[Aa][Rr][Mm]64/
+[Aa][Rr][Mm]64[Ee][Cc]/
+bld/
+[Oo]bj/
+[Oo]ut/
+[Ll]og/
+[Ll]ogs/
+
+# Build results on 'Bin' directories
+**/[Bb]in/*
+# Uncomment if you have tasks that rely on *.refresh files to move binaries
+# (https://github.com/github/gitignore/pull/3736)
+#!**/[Bb]in/*.refresh
+
+# Visual Studio 2015/2017 cache/options directory
+.vs/
+# Uncomment if you have tasks that create the project's static files in wwwroot
+#wwwroot/
+
+# Visual Studio 2017 auto generated files
+Generated\ Files/
+
+# MSTest test Results
+[Tt]est[Rr]esult*/
+[Bb]uild[Ll]og.*
+*.trx
+
+# NUnit
+*.VisualState.xml
+TestResult.xml
+nunit-*.xml
+
+# Approval Tests result files
+*.received.*
+
+# Build Results of an ATL Project
+[Dd]ebugPS/
+[Rr]eleasePS/
+dlldata.c
+
+# Benchmark Results
+BenchmarkDotNet.Artifacts/
+
+# .NET Core
+project.lock.json
+project.fragment.lock.json
+artifacts/
+
+# ASP.NET Scaffolding
+ScaffoldingReadMe.txt
+
+# StyleCop
+StyleCopReport.xml
+
+# Files built by Visual Studio
+*_i.c
+*_p.c
+*_h.h
+*.ilk
+*.meta
+*.obj
+*.idb
+*.iobj
+*.pch
+*.pdb
+*.ipdb
+*.pgc
+*.pgd
+*.rsp
+# but not Directory.Build.rsp, as it configures directory-level build defaults
+!Directory.Build.rsp
+*.sbr
+*.tlb
+*.tli
+*.tlh
+*.tmp
+*.tmp_proj
+*_wpftmp.csproj
+*.log
+*.tlog
+*.vspscc
+*.vssscc
+.builds
+*.pidb
+*.svclog
+*.scc
+
+# Chutzpah Test files
+_Chutzpah*
+
+# Visual C++ cache files
+ipch/
+*.aps
+*.ncb
+*.opendb
+*.opensdf
+*.sdf
+*.cachefile
+*.VC.db
+*.VC.VC.opendb
+
+# Visual Studio profiler
+*.psess
+*.vsp
+*.vspx
+*.sap
+
+# Visual Studio Trace Files
+*.e2e
+
+# TFS 2012 Local Workspace
+$tf/
+
+# Guidance Automation Toolkit
+*.gpState
+
+# ReSharper is a .NET coding add-in
+_ReSharper*/
+*.[Rr]e[Ss]harper
+*.DotSettings.user
+
+# TeamCity is a build add-in
+_TeamCity*
+
+# DotCover is a Code Coverage Tool
+*.dotCover
+
+# AxoCover is a Code Coverage Tool
+.axoCover/*
+!.axoCover/settings.json
+
+# Coverlet is a free, cross platform Code Coverage Tool
+coverage*.json
+coverage*.xml
+coverage*.info
+
+# Visual Studio code coverage results
+*.coverage
+*.coveragexml
+
+# NCrunch
+_NCrunch_*
+.NCrunch_*
+.*crunch*.local.xml
+nCrunchTemp_*
+
+# MightyMoose
+*.mm.*
+AutoTest.Net/
+
+# Web workbench (sass)
+.sass-cache/
+
+# Installshield output folder
+[Ee]xpress/
+
+# DocProject is a documentation generator add-in
+DocProject/buildhelp/
+DocProject/Help/*.HxT
+DocProject/Help/*.HxC
+DocProject/Help/*.hhc
+DocProject/Help/*.hhk
+DocProject/Help/*.hhp
+DocProject/Help/Html2
+DocProject/Help/html
+
+# Click-Once directory
+publish/
+
+# Publish Web Output
+*.[Pp]ublish.xml
+*.azurePubxml
+# Note: Comment the next line if you want to checkin your web deploy settings,
+# but database connection strings (with potential passwords) will be unencrypted
+*.pubxml
+*.publishproj
+
+# Microsoft Azure Web App publish settings. Comment the next line if you want to
+# checkin your Azure Web App publish settings, but sensitive information contained
+# in these scripts will be unencrypted
+PublishScripts/
+
+# NuGet Packages
+*.nupkg
+# NuGet Symbol Packages
+*.snupkg
+# The packages folder can be ignored because of Package Restore
+**/[Pp]ackages/*
+# except build/, which is used as an MSBuild target.
+!**/[Pp]ackages/build/
+# Uncomment if necessary however generally it will be regenerated when needed
+#!**/[Pp]ackages/repositories.config
+# NuGet v3's project.json files produces more ignorable files
+*.nuget.props
+*.nuget.targets
+
+# Microsoft Azure Build Output
+csx/
+*.build.csdef
+
+# Microsoft Azure Emulator
+ecf/
+rcf/
+
+# Windows Store app package directories and files
+AppPackages/
+BundleArtifacts/
+Package.StoreAssociation.xml
+_pkginfo.txt
+*.appx
+*.appxbundle
+*.appxupload
+
+# Visual Studio cache files
+# files ending in .cache can be ignored
+*.[Cc]ache
+# but keep track of directories ending in .cache
+!?*.[Cc]ache/
+
+# Others
+ClientBin/
+~$*
+*~
+*.dbmdl
+*.dbproj.schemaview
+*.jfm
+*.pfx
+*.publishsettings
+orleans.codegen.cs
+
+# Including strong name files can present a security risk
+# (https://github.com/github/gitignore/pull/2483#issue-259490424)
+#*.snk
+
+# Since there are multiple workflows, uncomment next line to ignore bower_components
+# (https://github.com/github/gitignore/pull/1529#issuecomment-104372622)
+#bower_components/
+
+# RIA/Silverlight projects
+Generated_Code/
+
+# Backup & report files from converting an old project file
+# to a newer Visual Studio version. Backup files are not needed,
+# because we have git ;-)
+_UpgradeReport_Files/
+Backup*/
+UpgradeLog*.XML
+UpgradeLog*.htm
+ServiceFabricBackup/
+*.rptproj.bak
+
+# SQL Server files
+*.mdf
+*.ldf
+*.ndf
+
+# Business Intelligence projects
+*.rdl.data
+*.bim.layout
+*.bim_*.settings
+*.rptproj.rsuser
+*- [Bb]ackup.rdl
+*- [Bb]ackup ([0-9]).rdl
+*- [Bb]ackup ([0-9][0-9]).rdl
+
+# Microsoft Fakes
+FakesAssemblies/
+
+# GhostDoc plugin setting file
+*.GhostDoc.xml
+
+# Node.js Tools for Visual Studio
+.ntvs_analysis.dat
+node_modules/
+
+# Visual Studio 6 build log
+*.plg
+
+# Visual Studio 6 workspace options file
+*.opt
+
+# Visual Studio 6 auto-generated workspace file (contains which files were open etc.)
+*.vbw
+
+# Visual Studio 6 auto-generated project file (contains which files were open etc.)
+*.vbp
+
+# Visual Studio 6 workspace and project file (working project files containing files to include in project)
+*.dsw
+*.dsp
+
+# Visual Studio 6 technical files
+*.ncb
+*.aps
+
+# Visual Studio LightSwitch build output
+**/*.HTMLClient/GeneratedArtifacts
+**/*.DesktopClient/GeneratedArtifacts
+**/*.DesktopClient/ModelManifest.xml
+**/*.Server/GeneratedArtifacts
+**/*.Server/ModelManifest.xml
+_Pvt_Extensions
+
+# Paket dependency manager
+**/.paket/paket.exe
+paket-files/
+
+# FAKE - F# Make
+**/.fake/
+
+# CodeRush personal settings
+**/.cr/personal
+
+# Python Tools for Visual Studio (PTVS)
+**/__pycache__/
+*.pyc
+
+# Cake - Uncomment if you are using it
+#tools/**
+#!tools/packages.config
+
+# Tabs Studio
+*.tss
+
+# Telerik's JustMock configuration file
+*.jmconfig
+
+# BizTalk build output
+*.btp.cs
+*.btm.cs
+*.odx.cs
+*.xsd.cs
+
+# OpenCover UI analysis results
+OpenCover/
+
+# Azure Stream Analytics local run output
+ASALocalRun/
+
+# MSBuild Binary and Structured Log
+*.binlog
+MSBuild_Logs/
+
+# AWS SAM Build and Temporary Artifacts folder
+.aws-sam
+
+# NVidia Nsight GPU debugger configuration file
+*.nvuser
+
+# MFractors (Xamarin productivity tool) working folder
+**/.mfractor/
+
+# Local History for Visual Studio
+**/.localhistory/
+
+# Visual Studio History (VSHistory) files
+.vshistory/
+
+# BeatPulse healthcheck temp database
+healthchecksdb
+
+# Backup folder for Package Reference Convert tool in Visual Studio 2017
+MigrationBackup/
+
+# Ionide (cross platform F# VS Code tools) working folder
+**/.ionide/
+
+# Fody - auto-generated XML schema
+FodyWeavers.xsd
+
+# VS Code files for those working on multiple tools
+.vscode/*
+!.vscode/settings.json
+!.vscode/tasks.json
+!.vscode/launch.json
+!.vscode/extensions.json
+!.vscode/*.code-snippets
+
+# Local History for Visual Studio Code
+.history/
+
+# Built Visual Studio Code Extensions
+*.vsix
+
+# Windows Installer files from build outputs
+*.cab
+*.msi
+*.msix
+*.msm
+*.msp
+
+# Created by https://www.toptal.com/developers/gitignore/api/jetbrains+all,visualstudiocode,vim,emacs,eclipse
+# Edit at https://www.toptal.com/developers/gitignore?templates=jetbrains+all,visualstudiocode,vim,emacs,eclipse
+
+### Eclipse ###
+.metadata
+bin/
+tmp/
+*.tmp
+*.bak
+*.swp
+*~.nib
+local.properties
+.settings/
+.loadpath
+.recommenders
+
+# External tool builders
+.externalToolBuilders/
+
+# Locally stored "Eclipse launch configurations"
+*.launch
+
+# PyDev specific (Python IDE for Eclipse)
+*.pydevproject
+
+# CDT-specific (C/C++ Development Tooling)
+.cproject
+
+# CDT- autotools
+.autotools
+
+# Java annotation processor (APT)
+.factorypath
+
+# PDT-specific (PHP Development Tools)
+.buildpath
+
+# sbteclipse plugin
+.target
+
+# Tern plugin
+.tern-project
+
+# TeXlipse plugin
+.texlipse
+
+# STS (Spring Tool Suite)
+.springBeans
+
+# Code Recommenders
+.recommenders/
+
+# Annotation Processing
+.apt_generated/
+.apt_generated_test/
+
+# Scala IDE specific (Scala & Java development for Eclipse)
+.cache-main
+.scala_dependencies
+.worksheet
+
+# Uncomment this line if you wish to ignore the project description file.
+# Typically, this file would be tracked if it contains build/dependency configurations:
+#.project
+
+### Eclipse Patch ###
+# Spring Boot Tooling
+.sts4-cache/
+
+### Emacs ###
+# -*- mode: gitignore; -*-
+*~
+\#*\#
+/.emacs.desktop
+/.emacs.desktop.lock
+*.elc
+auto-save-list
+tramp
+.\#*
+
+# Org-mode
+.org-id-locations
+*_archive
+
+# flymake-mode
+*_flymake.*
+
+# eshell files
+/eshell/history
+/eshell/lastdir
+
+# elpa packages
+/elpa/
+
+# reftex files
+*.rel
+
+# AUCTeX auto folder
+/auto/
+
+# cask packages
+.cask/
+dist/
+
+# Flycheck
+flycheck_*.el
+
+# server auth directory
+/server/
+
+# projectiles files
+.projectile
+
+# directory configuration
+.dir-locals.el
+
+# network security
+/network-security.data
+
+
+### JetBrains+all ###
+# Covers JetBrains IDEs: IntelliJ, RubyMine, PhpStorm, AppCode, PyCharm, CLion, Android Studio, WebStorm and Rider
+# Reference: https://intellij-support.jetbrains.com/hc/en-us/articles/206544839
+
+# User-specific stuff
+.idea/**/workspace.xml
+.idea/**/tasks.xml
+.idea/**/usage.statistics.xml
+.idea/**/dictionaries
+.idea/**/shelf
+
+# AWS User-specific
+.idea/**/aws.xml
+
+# Generated files
+.idea/**/contentModel.xml
+
+# Sensitive or high-churn files
+.idea/**/dataSources/
+.idea/**/dataSources.ids
+.idea/**/dataSources.local.xml
+.idea/**/sqlDataSources.xml
+.idea/**/dynamic.xml
+.idea/**/uiDesigner.xml
+.idea/**/dbnavigator.xml
+
+# Gradle
+.idea/**/gradle.xml
+.idea/**/libraries
+
+# Gradle and Maven with auto-import
+# When using Gradle or Maven with auto-import, you should exclude module files,
+# since they will be recreated, and may cause churn.  Uncomment if using
+# auto-import.
+# .idea/artifacts
+# .idea/compiler.xml
+# .idea/jarRepositories.xml
+# .idea/modules.xml
+# .idea/*.iml
+# .idea/modules
+# *.iml
+# *.ipr
+
+# CMake
+cmake-build-*/
+
+# Mongo Explorer plugin
+.idea/**/mongoSettings.xml
+
+# File-based project format
+*.iws
+
+# IntelliJ
+out/
+
+# mpeltonen/sbt-idea plugin
+.idea_modules/
+
+# JIRA plugin
+atlassian-ide-plugin.xml
+
+# Cursive Clojure plugin
+.idea/replstate.xml
+
+# SonarLint plugin
+.idea/sonarlint/
+
+# Crashlytics plugin (for Android Studio and IntelliJ)
+com_crashlytics_export_strings.xml
+crashlytics.properties
+crashlytics-build.properties
+fabric.properties
+
+# Editor-based Rest Client
+.idea/httpRequests
+
+# Android studio 3.1+ serialized cache file
+.idea/caches/build_file_checksums.ser
+
+### JetBrains+all Patch ###
+# Ignore everything but code style settings and run configurations
+# that are supposed to be shared within teams.
+
+.idea/*
+
+!.idea/codeStyles
+!.idea/runConfigurations
+
+### Vim ###
+# Swap
+[._]*.s[a-v][a-z]
+!*.svg  # comment out if you don't need vector files
+[._]*.sw[a-p]
+[._]s[a-rt-v][a-z]
+[._]ss[a-gi-z]
+[._]sw[a-p]
+
+# Session
+Session.vim
+Sessionx.vim
+
+# Temporary
+.netrwhist
+# Auto-generated tag files
+tags
+# Persistent undo
+[._]*.un~
+
+### VisualStudioCode ###
+.vscode/*
+!.vscode/settings.json
+!.vscode/tasks.json
+!.vscode/launch.json
+!.vscode/extensions.json
+!.vscode/*.code-snippets
+
+# Local History for Visual Studio Code
+.history/
+
+# Built Visual Studio Code Extensions
+*.vsix
+
+### VisualStudioCode Patch ###
+# Ignore all local history of files
+.history
+.ionide
+
+# End of https://www.toptal.com/developers/gitignore/api/jetbrains+all,visualstudiocode,vim,emacs,eclipse
diff --git a/README.md b/README.md
new file mode 100644
index 0000000..2cbba77
--- /dev/null
+++ b/README.md
@@ -0,0 +1,9 @@
+# template
+
+![Build](https://github.com/dysshanks/template/actions/workflows/readme-generator.yml/badge.svg)
+![Issues](https://img.shields.io/github/issues/dysshanks/template)
+![Stars](https://img.shields.io/github/stars/dysshanks/template)
+![License](https://img.shields.io/github/license/dysshanks/template)
+
+---
+*This README was auto-generated.*
diff --git a/docs/COMMITS.md b/docs/COMMITS.md
new file mode 100644
index 0000000..44e8ffc
--- /dev/null
+++ b/docs/COMMITS.md
@@ -0,0 +1,384 @@
+
+## Update readme.yml
+- **Commit:** `3a0d8a017b619e8741934e4fa3df6292696fde9f`
+- **Date:** 2025-08-30 17:33:20 +0200
+- **Author:** dysshanks
+
+### Preview (first 3 lines of changes)
+```diff
+commit 3a0d8a017b619e8741934e4fa3df6292696fde9f
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:33:20 2025 +0200
+```
+
+<details><summary>Full changes</summary>
+
+```diff
+commit 3a0d8a017b619e8741934e4fa3df6292696fde9f
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:33:20 2025 +0200
+
+    Update readme.yml
+    
+    i hope it works now
+
+diff --git a/.github/workflows/readme.yml b/.github/workflows/readme.yml
+index 3c96d2d..0091989 100644
+--- a/.github/workflows/readme.yml
++++ b/.github/workflows/readme.yml
+@@ -2,8 +2,7 @@ name: Generate README
+ 
+ on:
+   push:
+-    branches:
+-      - main
++    branches: [ main ]
+   workflow_dispatch:
+ 
+ permissions:
+@@ -13,44 +12,43 @@ jobs:
+   generate-readme:
+     runs-on: ubuntu-latest
+     steps:
+-      - name: Checkout repo
+-        uses: actions/checkout@v3
++      - uses: actions/checkout@v3
+ 
+       - name: Get repository name
+         id: repo
+-        run: echo "repo_name=${GITHUB_REPOSITORY##*/}" >> $GITHUB_OUTPUT
++        run: echo "repo_name=${GITHUB_REPOSITORY##*/}" >> "$GITHUB_OUTPUT"
+ 
+       - name: Check if README exists
+         id: check_readme
+         run: |
+           if [ -f README.md ]; then
+-            echo "exists=true" >> $GITHUB_OUTPUT
++            echo "exists=true" >> "$GITHUB_OUTPUT"
+           else
+-            echo "exists=false" >> $GITHUB_OUTPUT
++            echo "exists=false" >> "$GITHUB_OUTPUT"
+           fi
+ 
+-      - name: Generate README
+-        if: steps.check_readme.outputs.exists == 'false'
+-        run: |
+-          cat <<EOF > README.md
+-          # ${{
+-            steps.repo.outputs.repo_name
+-          }}
+-
+-          ![Build](https://github.com/${GITHUB_REPOSITORY}/actions/workflows/readme-generator.yml/badge.svg)
+-          ![Issues](https://img.shields.io/github/issues/${GITHUB_REPOSITORY})
+-          ![Stars](https://img.shields.io/github/stars/${GITHUB_REPOSITORY})
+-          ![License](https://img.shields.io/github/license/${GITHUB_REPOSITORY})
+-
+-          ---
+-          *This README was auto-generated.*
+-          EOF
++          - name: Generate README
++          if: ${{ steps.check_readme.outputs.exists == 'false' }}
++          run: |
++            cat <<EOF > README.md
++        # ${{ steps.repo.outputs.repo_name }}
++        
++        ![Build](https://github.com/${{ github.repository }}/actions/workflows/readme-generator.yml/badge.svg)
++        ![Issues](https://img.shields.io/github/issues/${{ github.repository }})
++        ![Stars](https://img.shields.io/github/stars/${{ github.repository }})
++        ![License](https://img.shields.io/github/license/${{ github.repository }})
++        
++        ---
++        *This README was auto-generated.*
++        EOF
++        
+ 
+       - name: Commit and push README
+-        if: steps.check_readme.outputs.exists == 'false'
++        if: ${{ steps.check_readme.outputs.exists == 'false' }}
+         run: |
+           git config --global user.name "github-actions[bot]"
+           git config --global user.email "github-actions[bot]@users.noreply.github.com"
++          git pull --rebase origin main
+           git add README.md
+           git commit -m "Auto-generate README.md"
+           git push
+```
+
+</details>
+
+
+## Update readme.yml
+- **Commit:** `7a64ab4f6262cefa96f87db78b07f28a2af565a2`
+- **Date:** 2025-08-30 17:28:07 +0200
+- **Author:** dysshanks
+
+### Preview (first 3 lines of changes)
+```diff
+commit 7a64ab4f6262cefa96f87db78b07f28a2af565a2
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:28:07 2025 +0200
+```
+
+<details><summary>Full changes</summary>
+
+```diff
+commit 7a64ab4f6262cefa96f87db78b07f28a2af565a2
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:28:07 2025 +0200
+
+    Update readme.yml
+    
+    gave write permission
+
+diff --git a/.github/workflows/readme.yml b/.github/workflows/readme.yml
+index d991b6b..3c96d2d 100644
+--- a/.github/workflows/readme.yml
++++ b/.github/workflows/readme.yml
+@@ -6,6 +6,9 @@ on:
+       - main
+   workflow_dispatch:
+ 
++permissions:
++  contents: write
++
+ jobs:
+   generate-readme:
+     runs-on: ubuntu-latest
+```
+
+</details>
+
+
+## Merge branch 'main' of https://github.com/dysshanks/template
+- **Commit:** `5880f7dfc55444d926491a14c6bf6fbbc4a3cdd9`
+- **Date:** 2025-08-30 17:26:12 +0200
+- **Author:** dysshanks
+
+### Preview (first 3 lines of changes)
+```diff
+commit 5880f7dfc55444d926491a14c6bf6fbbc4a3cdd9
+Merge: 9946f52 2f99eef
+Author: dysshanks <ryanvdvorst@outlook.com>
+```
+
+<details><summary>Full changes</summary>
+
+```diff
+commit 5880f7dfc55444d926491a14c6bf6fbbc4a3cdd9
+Merge: 9946f52 2f99eef
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:26:12 2025 +0200
+
+    Merge branch 'main' of https://github.com/dysshanks/template
+
+```
+
+</details>
+
+## Create .editorconfig
+- **Commit:** `9946f52f1752238eee6ade31fb112f88573d69cf`
+- **Date:** 2025-08-30 17:25:58 +0200
+- **Author:** dysshanks
+
+### Preview (first 3 lines of changes)
+```diff
+commit 9946f52f1752238eee6ade31fb112f88573d69cf
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:25:58 2025 +0200
+```
+
+<details><summary>Full changes</summary>
+
+```diff
+commit 9946f52f1752238eee6ade31fb112f88573d69cf
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:25:58 2025 +0200
+
+    Create .editorconfig
+    
+    made a simple editorconfig
+
+diff --git a/.editorconfig b/.editorconfig
+new file mode 100644
+index 0000000..86199ac
+--- /dev/null
++++ b/.editorconfig
+@@ -0,0 +1,9 @@
++root = true
++
++[*]
++charset = utf-8
++end_of_line = lf
++indent_style = tab
++insert_final_newline = true
++tab_width = 2
++trim_trailing_whitespace = true
+\ No newline at end of file
+```
+
+</details>
+
+
+## Merge branch 'main' of https://github.com/dysshanks/template
+- **Commit:** `8177c06143bd562d763d40b5728322c53d90d386`
+- **Date:** 2025-08-30 17:22:30 +0200
+- **Author:** dysshanks
+
+### Preview (first 3 lines of changes)
+```diff
+commit 8177c06143bd562d763d40b5728322c53d90d386
+Merge: 1d6ad64 4f7dbd5
+Author: dysshanks <ryanvdvorst@outlook.com>
+```
+
+<details><summary>Full changes</summary>
+
+```diff
+commit 8177c06143bd562d763d40b5728322c53d90d386
+Merge: 1d6ad64 4f7dbd5
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:22:30 2025 +0200
+
+    Merge branch 'main' of https://github.com/dysshanks/template
+
+```
+
+</details>
+
+## auto readme maker
+- **Commit:** `1d6ad641d9c7a8df24509f4175a81beea936ee08`
+- **Date:** 2025-08-30 17:22:02 +0200
+- **Author:** dysshanks
+
+### Preview (first 3 lines of changes)
+```diff
+commit 1d6ad641d9c7a8df24509f4175a81beea936ee08
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:22:02 2025 +0200
+```
+
+<details><summary>Full changes</summary>
+
+```diff
+commit 1d6ad641d9c7a8df24509f4175a81beea936ee08
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:22:02 2025 +0200
+
+    auto readme maker
+
+diff --git a/.github/workflows/readme.yml b/.github/workflows/readme.yml
+new file mode 100644
+index 0000000..d991b6b
+--- /dev/null
++++ b/.github/workflows/readme.yml
+@@ -0,0 +1,53 @@
++name: Generate README
++
++on:
++  push:
++    branches:
++      - main
++  workflow_dispatch:
++
++jobs:
++  generate-readme:
++    runs-on: ubuntu-latest
++    steps:
++      - name: Checkout repo
++        uses: actions/checkout@v3
++
++      - name: Get repository name
++        id: repo
++        run: echo "repo_name=${GITHUB_REPOSITORY##*/}" >> $GITHUB_OUTPUT
++
++      - name: Check if README exists
++        id: check_readme
++        run: |
++          if [ -f README.md ]; then
++            echo "exists=true" >> $GITHUB_OUTPUT
++          else
++            echo "exists=false" >> $GITHUB_OUTPUT
++          fi
++
++      - name: Generate README
++        if: steps.check_readme.outputs.exists == 'false'
++        run: |
++          cat <<EOF > README.md
++          # ${{
++            steps.repo.outputs.repo_name
++          }}
++
++          ![Build](https://github.com/${GITHUB_REPOSITORY}/actions/workflows/readme-generator.yml/badge.svg)
++          ![Issues](https://img.shields.io/github/issues/${GITHUB_REPOSITORY})
++          ![Stars](https://img.shields.io/github/stars/${GITHUB_REPOSITORY})
++          ![License](https://img.shields.io/github/license/${GITHUB_REPOSITORY})
++
++          ---
++          *This README was auto-generated.*
++          EOF
++
++      - name: Commit and push README
++        if: steps.check_readme.outputs.exists == 'false'
++        run: |
++          git config --global user.name "github-actions[bot]"
++          git config --global user.email "github-actions[bot]@users.noreply.github.com"
++          git add README.md
++          git commit -m "Auto-generate README.md"
++          git push
+```
+
+</details>
+
+
+## updated logger
+- **Commit:** `3f2b9e291a5841f85323464fce2e2e9e50489216`
+- **Date:** 2025-08-30 17:11:29 +0200
+- **Author:** dysshanks
+
+### Preview (first 3 lines of changes)
+```diff
+commit 3f2b9e291a5841f85323464fce2e2e9e50489216
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:11:29 2025 +0200
+```
+
+<details><summary>Full changes</summary>
+
+```diff
+commit 3f2b9e291a5841f85323464fce2e2e9e50489216
+Author: dysshanks <ryanvdvorst@outlook.com>
+Date:   Sat Aug 30 17:11:29 2025 +0200
+
+    updated logger
+    
+    hopefully made the permissions work and it should not loop on itself
+
+diff --git a/.github/workflows/commit-log.yml b/.github/workflows/commit-log.yml
+index 08479d6..ab27135 100644
+--- a/.github/workflows/commit-log.yml
++++ b/.github/workflows/commit-log.yml
+@@ -5,8 +5,12 @@ on:
+     branches:
+       - main
+ 
++permissions:
++  contents: write
++
+ jobs:
+   log-commits:
++    if: github.actor != 'github-actions[bot]'
+     runs-on: ubuntu-latest
+ 
+     steps:
+@@ -14,6 +18,7 @@ jobs:
+         uses: actions/checkout@v3
+         with:
+           fetch-depth: 0
++          token: ${{ secrets.GITHUB_TOKEN }}
+ 
+       - name: Gather commit info
+         run: |
+```
+
+</details>
+
```

</details>


## Update readme.yml
- **Commit:** `3a0d8a017b619e8741934e4fa3df6292696fde9f`
- **Date:** 2025-08-30 17:33:20 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 3a0d8a017b619e8741934e4fa3df6292696fde9f
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:33:20 2025 +0200
```

<details><summary>Full changes</summary>

```diff
commit 3a0d8a017b619e8741934e4fa3df6292696fde9f
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:33:20 2025 +0200

    Update readme.yml
    
    i hope it works now

diff --git a/.github/workflows/readme.yml b/.github/workflows/readme.yml
index 3c96d2d..0091989 100644
--- a/.github/workflows/readme.yml
+++ b/.github/workflows/readme.yml
@@ -2,8 +2,7 @@ name: Generate README
 
 on:
   push:
-    branches:
-      - main
+    branches: [ main ]
   workflow_dispatch:
 
 permissions:
@@ -13,44 +12,43 @@ jobs:
   generate-readme:
     runs-on: ubuntu-latest
     steps:
-      - name: Checkout repo
-        uses: actions/checkout@v3
+      - uses: actions/checkout@v3
 
       - name: Get repository name
         id: repo
-        run: echo "repo_name=${GITHUB_REPOSITORY##*/}" >> $GITHUB_OUTPUT
+        run: echo "repo_name=${GITHUB_REPOSITORY##*/}" >> "$GITHUB_OUTPUT"
 
       - name: Check if README exists
         id: check_readme
         run: |
           if [ -f README.md ]; then
-            echo "exists=true" >> $GITHUB_OUTPUT
+            echo "exists=true" >> "$GITHUB_OUTPUT"
           else
-            echo "exists=false" >> $GITHUB_OUTPUT
+            echo "exists=false" >> "$GITHUB_OUTPUT"
           fi
 
-      - name: Generate README
-        if: steps.check_readme.outputs.exists == 'false'
-        run: |
-          cat <<EOF > README.md
-          # ${{
-            steps.repo.outputs.repo_name
-          }}
-
-          ![Build](https://github.com/${GITHUB_REPOSITORY}/actions/workflows/readme-generator.yml/badge.svg)
-          ![Issues](https://img.shields.io/github/issues/${GITHUB_REPOSITORY})
-          ![Stars](https://img.shields.io/github/stars/${GITHUB_REPOSITORY})
-          ![License](https://img.shields.io/github/license/${GITHUB_REPOSITORY})
-
-          ---
-          *This README was auto-generated.*
-          EOF
+          - name: Generate README
+          if: ${{ steps.check_readme.outputs.exists == 'false' }}
+          run: |
+            cat <<EOF > README.md
+        # ${{ steps.repo.outputs.repo_name }}
+        
+        ![Build](https://github.com/${{ github.repository }}/actions/workflows/readme-generator.yml/badge.svg)
+        ![Issues](https://img.shields.io/github/issues/${{ github.repository }})
+        ![Stars](https://img.shields.io/github/stars/${{ github.repository }})
+        ![License](https://img.shields.io/github/license/${{ github.repository }})
+        
+        ---
+        *This README was auto-generated.*
+        EOF
+        
 
       - name: Commit and push README
-        if: steps.check_readme.outputs.exists == 'false'
+        if: ${{ steps.check_readme.outputs.exists == 'false' }}
         run: |
           git config --global user.name "github-actions[bot]"
           git config --global user.email "github-actions[bot]@users.noreply.github.com"
+          git pull --rebase origin main
           git add README.md
           git commit -m "Auto-generate README.md"
           git push
```

</details>


## Update readme.yml
- **Commit:** `7a64ab4f6262cefa96f87db78b07f28a2af565a2`
- **Date:** 2025-08-30 17:28:07 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 7a64ab4f6262cefa96f87db78b07f28a2af565a2
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:28:07 2025 +0200
```

<details><summary>Full changes</summary>

```diff
commit 7a64ab4f6262cefa96f87db78b07f28a2af565a2
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:28:07 2025 +0200

    Update readme.yml
    
    gave write permission

diff --git a/.github/workflows/readme.yml b/.github/workflows/readme.yml
index d991b6b..3c96d2d 100644
--- a/.github/workflows/readme.yml
+++ b/.github/workflows/readme.yml
@@ -6,6 +6,9 @@ on:
       - main
   workflow_dispatch:
 
+permissions:
+  contents: write
+
 jobs:
   generate-readme:
     runs-on: ubuntu-latest
```

</details>


## Merge branch 'main' of https://github.com/dysshanks/template
- **Commit:** `5880f7dfc55444d926491a14c6bf6fbbc4a3cdd9`
- **Date:** 2025-08-30 17:26:12 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 5880f7dfc55444d926491a14c6bf6fbbc4a3cdd9
Merge: 9946f52 2f99eef
Author: dysshanks <ryanvdvorst@outlook.com>
```

<details><summary>Full changes</summary>

```diff
commit 5880f7dfc55444d926491a14c6bf6fbbc4a3cdd9
Merge: 9946f52 2f99eef
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:26:12 2025 +0200

    Merge branch 'main' of https://github.com/dysshanks/template

```

</details>

## Create .editorconfig
- **Commit:** `9946f52f1752238eee6ade31fb112f88573d69cf`
- **Date:** 2025-08-30 17:25:58 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 9946f52f1752238eee6ade31fb112f88573d69cf
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:25:58 2025 +0200
```

<details><summary>Full changes</summary>

```diff
commit 9946f52f1752238eee6ade31fb112f88573d69cf
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:25:58 2025 +0200

    Create .editorconfig
    
    made a simple editorconfig

diff --git a/.editorconfig b/.editorconfig
new file mode 100644
index 0000000..86199ac
--- /dev/null
+++ b/.editorconfig
@@ -0,0 +1,9 @@
+root = true
+
+[*]
+charset = utf-8
+end_of_line = lf
+indent_style = tab
+insert_final_newline = true
+tab_width = 2
+trim_trailing_whitespace = true
\ No newline at end of file
```

</details>


## Merge branch 'main' of https://github.com/dysshanks/template
- **Commit:** `8177c06143bd562d763d40b5728322c53d90d386`
- **Date:** 2025-08-30 17:22:30 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 8177c06143bd562d763d40b5728322c53d90d386
Merge: 1d6ad64 4f7dbd5
Author: dysshanks <ryanvdvorst@outlook.com>
```

<details><summary>Full changes</summary>

```diff
commit 8177c06143bd562d763d40b5728322c53d90d386
Merge: 1d6ad64 4f7dbd5
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:22:30 2025 +0200

    Merge branch 'main' of https://github.com/dysshanks/template

```

</details>

## auto readme maker
- **Commit:** `1d6ad641d9c7a8df24509f4175a81beea936ee08`
- **Date:** 2025-08-30 17:22:02 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 1d6ad641d9c7a8df24509f4175a81beea936ee08
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:22:02 2025 +0200
```

<details><summary>Full changes</summary>

```diff
commit 1d6ad641d9c7a8df24509f4175a81beea936ee08
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:22:02 2025 +0200

    auto readme maker

diff --git a/.github/workflows/readme.yml b/.github/workflows/readme.yml
new file mode 100644
index 0000000..d991b6b
--- /dev/null
+++ b/.github/workflows/readme.yml
@@ -0,0 +1,53 @@
+name: Generate README
+
+on:
+  push:
+    branches:
+      - main
+  workflow_dispatch:
+
+jobs:
+  generate-readme:
+    runs-on: ubuntu-latest
+    steps:
+      - name: Checkout repo
+        uses: actions/checkout@v3
+
+      - name: Get repository name
+        id: repo
+        run: echo "repo_name=${GITHUB_REPOSITORY##*/}" >> $GITHUB_OUTPUT
+
+      - name: Check if README exists
+        id: check_readme
+        run: |
+          if [ -f README.md ]; then
+            echo "exists=true" >> $GITHUB_OUTPUT
+          else
+            echo "exists=false" >> $GITHUB_OUTPUT
+          fi
+
+      - name: Generate README
+        if: steps.check_readme.outputs.exists == 'false'
+        run: |
+          cat <<EOF > README.md
+          # ${{
+            steps.repo.outputs.repo_name
+          }}
+
+          ![Build](https://github.com/${GITHUB_REPOSITORY}/actions/workflows/readme-generator.yml/badge.svg)
+          ![Issues](https://img.shields.io/github/issues/${GITHUB_REPOSITORY})
+          ![Stars](https://img.shields.io/github/stars/${GITHUB_REPOSITORY})
+          ![License](https://img.shields.io/github/license/${GITHUB_REPOSITORY})
+
+          ---
+          *This README was auto-generated.*
+          EOF
+
+      - name: Commit and push README
+        if: steps.check_readme.outputs.exists == 'false'
+        run: |
+          git config --global user.name "github-actions[bot]"
+          git config --global user.email "github-actions[bot]@users.noreply.github.com"
+          git add README.md
+          git commit -m "Auto-generate README.md"
+          git push
```

</details>


## updated logger
- **Commit:** `3f2b9e291a5841f85323464fce2e2e9e50489216`
- **Date:** 2025-08-30 17:11:29 +0200
- **Author:** dysshanks

### Preview (first 3 lines of changes)
```diff
commit 3f2b9e291a5841f85323464fce2e2e9e50489216
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:11:29 2025 +0200
```

<details><summary>Full changes</summary>

```diff
commit 3f2b9e291a5841f85323464fce2e2e9e50489216
Author: dysshanks <ryanvdvorst@outlook.com>
Date:   Sat Aug 30 17:11:29 2025 +0200

    updated logger
    
    hopefully made the permissions work and it should not loop on itself

diff --git a/.github/workflows/commit-log.yml b/.github/workflows/commit-log.yml
index 08479d6..ab27135 100644
--- a/.github/workflows/commit-log.yml
+++ b/.github/workflows/commit-log.yml
@@ -5,8 +5,12 @@ on:
     branches:
       - main
 
+permissions:
+  contents: write
+
 jobs:
   log-commits:
+    if: github.actor != 'github-actions[bot]'
     runs-on: ubuntu-latest
 
     steps:
@@ -14,6 +18,7 @@ jobs:
         uses: actions/checkout@v3
         with:
           fetch-depth: 0
+          token: ${{ secrets.GITHUB_TOKEN }}
 
       - name: Gather commit info
         run: |
```

</details>

