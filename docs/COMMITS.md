
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

