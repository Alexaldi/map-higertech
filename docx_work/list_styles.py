from docx import Document

doc = Document(r'C:\Users\Aspire 7\Downloads\Manual_Book_User_SIH3_Maluku_Final.docx')
for style in doc.styles:
    if style.type == 1:
        font = style.font
        pf = style.paragraph_format
        print(style.name, '| font=', font.name, '| size=', font.size.pt if font.size else None, '| bold=', font.bold, '| italic=', font.italic, '| before=', pf.space_before, '| after=', pf.space_after, '| line=', pf.line_spacing)
