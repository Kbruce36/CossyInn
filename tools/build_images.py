"""Generate responsive WebP + JPEG derivatives for the Cosy Inn site."""
import os
import sys
from PIL import Image, ImageOps

SRC = r"C:\Users\HP\Desktop\my projects\cosy Inn\CossyInn\src\assets"
OUT = r"C:\Users\HP\Desktop\my projects\cosy Inn\CossyInn\public_html\assets\img"

WIDTHS = [480, 800, 1200, 1920]

# name -> (subfolder, crop aspect or None)
JOBS = {
    "stock": None,
    "photos": None,
    "brand": None,
}


def derive(src_path, out_dir, stem):
    img = Image.open(src_path)
    img = ImageOps.exif_transpose(img)
    if img.mode not in ("RGB",):
        img = img.convert("RGB")
    ow, oh = img.size
    made = []
    for w in WIDTHS:
        if w > ow:
            continue
        h = round(oh * w / ow)
        resized = img.resize((w, h), Image.LANCZOS)
        webp = os.path.join(out_dir, f"{stem}-{w}.webp")
        jpg = os.path.join(out_dir, f"{stem}-{w}.jpg")
        resized.save(webp, "WEBP", quality=76, method=6)
        resized.save(jpg, "JPEG", quality=78, optimize=True, progressive=True)
        made.append((w, h))
    # always emit a full-size fallback at the largest produced width
    if not made:
        w, h = ow, oh
        img.save(os.path.join(out_dir, f"{stem}-{w}.webp"), "WEBP", quality=76, method=6)
        img.save(os.path.join(out_dir, f"{stem}-{w}.jpg"), "JPEG", quality=80,
                 optimize=True, progressive=True)
        made.append((w, h))
    return ow, oh, made


def main():
    manifest = []
    for sub in JOBS:
        src_dir = os.path.join(SRC, sub)
        out_dir = os.path.join(OUT, sub)
        os.makedirs(out_dir, exist_ok=True)
        if not os.path.isdir(src_dir):
            continue
        for fn in sorted(os.listdir(src_dir)):
            if not fn.lower().endswith((".jpg", ".jpeg", ".png")):
                continue
            stem = os.path.splitext(fn)[0]
            ow, oh, made = derive(os.path.join(src_dir, fn), out_dir, stem)
            widths = ",".join(str(w) for w, _ in made)
            manifest.append(f"{sub}/{stem} orig={ow}x{oh} ratio={ow/oh:.3f} widths={widths}")
            print(f"  {sub}/{stem:22s} {ow}x{oh}  ratio {ow/oh:.3f}  -> {widths}")

    with open(os.path.join(OUT, "_manifest.txt"), "w", encoding="utf-8") as f:
        f.write("\n".join(manifest) + "\n")
    print(f"\n{len(manifest)} source images processed.")


if __name__ == "__main__":
    main()
