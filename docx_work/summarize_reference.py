from pathlib import Path
from docx import Document

doc = Document(Path(r'C:\Users\Aspire 7\Downloads\Manual_Book_User_SIH3_Maluku_Final.docx'))
for i, p in enumerate(doc.paragraphs, 1):
    text = p.text.strip()
    if not text:
        continue
    if p.style.name.startswith('Heading') or p.style.name in {'Quote'} or text[:2].isdigit():
        print(f'{i:03d} | {p.style.name:<10} | {text}')

for i, shape in enumerate(doc.inline_shapes, 1):
    print(f'SHAPE {i}: width={shape.width.inches:.2f} height={shape.height.inches:.2f}')

print('PACKAGE IMAGE RELS')
for rel in doc.part.rels.values():
    if 'image' in rel.reltype:
        print(rel.rId, rel.target_ref)
