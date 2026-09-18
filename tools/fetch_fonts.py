"""Self-host the site fonts as VARIABLE woff2 (latin subset only).

Requesting a weight RANGE from Google Fonts returns one variable file covering
every weight in that range, instead of one static file per weight. For Inter
that is ~50KB total rather than 47KB x 3.
"""
import os
import re
import shutil
import urllib.request

OUT = r"C:\Users\HP\Desktop\my projects\cosy Inn\CossyInn\public_html\assets\fonts"
CSS = r"C:\Users\HP\Desktop\my projects\cosy Inn\CossyInn\public_html\assets\css\fonts.css"

if os.path.isdir(OUT):
    shutil.rmtree(OUT)
os.makedirs(OUT, exist_ok=True)

UA = {"User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 "
                    "(KHTML, like Gecko) Chrome/124.0 Safari/537.36"}

# slug -> Google Fonts family spec (weight RANGES give variable files)
FAMILIES = {
    "inter":    "Inter:wght@400..600",
    "playfair": "Playfair+Display:wght@600..700",
    "dancing":  "Dancing+Script:wght@600..700",
}

face_re = re.compile(
    r"/\*\s*(?P<subset>[\w\[\]-]+)\s*\*/\s*@font-face\s*\{(?P<body>[^}]+)\}", re.S)


def grab(url):
    with urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=40) as r:
        return r.read().decode("utf-8")


faces = []
for key, spec in FAMILIES.items():
    css = grab(f"https://fonts.googleapis.com/css2?family={spec}&display=swap")
    for m in face_re.finditer(css):
        if m.group("subset") != "latin":
            continue
        body  = m.group("body")
        fam   = re.search(r"font-family:\s*'([^']+)'", body).group(1)
        wght  = re.search(r"font-weight:\s*([\d\s]+);", body).group(1).strip()
        style = re.search(r"font-style:\s*(\w+)", body).group(1)
        url   = re.search(r"url\((https://[^)]+\.woff2)\)", body).group(1)
        rng   = re.search(r"unicode-range:\s*([^;]+);", body)

        fname = f"{key}.woff2"
        with urllib.request.urlopen(urllib.request.Request(url, headers=UA), timeout=40) as r:
            data = r.read()
        with open(os.path.join(OUT, fname), "wb") as f:
            f.write(data)

        faces.append({"family": fam, "weight": wght, "style": style,
                      "file": fname, "range": rng.group(1) if rng else None})
        variable = " (variable)" if " " in wght else ""
        print(f"  {fname:16s} {len(data)//1024:4d}KB  {fam} {wght}{variable}")
        break  # one latin face per family is all we need

lines = ["/* Self-hosted variable fonts, latin subset. Generated, do not edit. */"]
for f in faces:
    lines.append(
        "@font-face{\n"
        f"  font-family:'{f['family']}';\n"
        f"  font-style:{f['style']};\n"
        f"  font-weight:{f['weight']};\n"
        "  font-display:swap;\n"
        f"  src:url('../fonts/{f['file']}') format('woff2-variations');\n"
        + (f"  unicode-range:{f['range']};\n" if f["range"] else "")
        + "}"
    )

with open(CSS, "w", encoding="utf-8") as f:
    f.write("\n".join(lines) + "\n")

total = sum(os.path.getsize(os.path.join(OUT, x)) for x in os.listdir(OUT))
print(f"\n{len(faces)} families, {total//1024}KB total -> {CSS}")
