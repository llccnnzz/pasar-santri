#!/usr/bin/env node

import fs from 'fs-extra';
import path from 'path';
import yaml from 'yaml';
import pdf from 'html-pdf';
import { marked } from 'marked';
import { fileURLToPath } from 'url';

// Get current file directory for ES modules
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Base directory for docs
const DOCS_DIR = __dirname;
const OUTPUT_PATH = path.join(DOCS_DIR, '../public/docs/User-Manual.pdf');

console.log('Pasar Santri Marketplace - User Manual PDF Generator');
console.log('=' .repeat(60));

async function loadYamlFile(filename) {
    try {
        const filePath = path.join(DOCS_DIR, filename);
        const content = await fs.readFile(filePath, 'utf8');
        return yaml.parse(content);
    } catch (error) {
        console.error(`Error loading ${filename}:`, error.message);
        throw error;
    }
}

async function loadMarkdownFile(filename) {
    try {
        const filePath = path.join(DOCS_DIR, filename);
        const exists = await fs.pathExists(filePath);

        if (!exists) {
            console.warn(` File not found: ${filename}, skipping...`);
            return null;
        }

        const content = await fs.readFile(filePath, 'utf8');
        return content;
    } catch (error) {
        console.error(`Error loading ${filename}:`, error.message);
        return null;
    }
}

function generateTableOfContents(orderConfig) {
    let toc = '\n# Daftar Isi\n\n';

    let pageNumber = 1;

    // Add cover and intro
    toc += `1. **Pengantar** ............................ ${pageNumber}\n`;
    pageNumber += 2;

    let sectionNumber = 2;

    orderConfig.sections.forEach(section => {
        toc += `\n${sectionNumber}. **${section.name}** ............................ ${pageNumber}\n`;

        if (section.files) {
            section.files.forEach((file, index) => {
                const subNumber = `${sectionNumber}.${index + 1}`;
                toc += `   ${subNumber} ${file.title} ............................ ${pageNumber + index + 1}\n`;
            });
            pageNumber += section.files.length + 1;
        } else {
            pageNumber += 1;
        }

        sectionNumber++;
    });

    toc += '\n<div style="page-break-after: always;"></div>\n\n';
    return toc;
}

async function combineMarkdownFiles() {
    console.log('Loading configuration files...');

    // Load configuration files
    const orderConfig = await loadYamlFile('order.yaml');
    const metadata = await loadYamlFile('metadata.yaml');

    console.log('Combining markdown files...');

    let combinedContent = '';

    // Add cover page
    console.log('   ├── Adding cover page...');
    const coverContent = await loadMarkdownFile(orderConfig.cover);
    if (coverContent) {
        combinedContent += coverContent + '\n\n';
    }

    // Add table of contents
    console.log('   ├── Generating table of contents...');
    const tocContent = generateTableOfContents(orderConfig);
    combinedContent += tocContent;

    // Add sections
    for (const section of orderConfig.sections) {
        console.log(`   ├── Adding section: ${section.name}`);

        // Add section header
        combinedContent += `\n# ${section.name}\n\n`;
        combinedContent += '<div style="page-break-after: always;"></div>\n\n';

        if (section.file) {
            // Single file section
            const content = await loadMarkdownFile(section.file);
            if (content) {
                combinedContent += content + '\n\n';
                combinedContent += '<div style="page-break-after: always;"></div>\n\n';
            }
        } else if (section.files) {
            // Multiple files section
            for (const fileInfo of section.files) {
                console.log(`      └── Adding: ${fileInfo.title}`);
                const content = await loadMarkdownFile(fileInfo.file);
                if (content) {
                    // Add subsection header
                    combinedContent += `## ${fileInfo.title}\n\n`;
                    combinedContent += content + '\n\n';
                    combinedContent += '<div style="page-break-after: always;"></div>\n\n';
                }
            }
        }
    }

    // Add footer with copyright
    combinedContent += `\n---\n\n${metadata.copyright.notice}\n\n${metadata.copyright.permissions}`;

    return combinedContent;
}

async function generatePDF() {
    try {
        console.log('Preparing document generation...');

        // Load order configuration for PDF options
        const orderConfig = await loadYamlFile('order.yaml');
        const metadata = await loadYamlFile('metadata.yaml');

        // Combine all markdown content
        const combinedMarkdown = await combineMarkdownFiles();

        console.log('📄 Converting markdown to HTML...');

        // Configure marked options
        marked.setOptions({
            breaks: true,
            gfm: true,
            headerIds: true,
            mangle: false
        });

        // Convert markdown to HTML
        const htmlContent = marked(combinedMarkdown);

        // Create styled HTML document
        const styledHtml = `
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>${metadata.document.title}</title>
    <style>
        @media print {
            body { margin: 0; }
            .page-break { page-break-after: always; }
            h1 { page-break-before: always; }
            h1:first-child { page-break-before: auto; }
        }

        body {
            font-family: ${metadata.styles?.font_family || 'Arial, sans-serif'};
            font-size: ${metadata.styles?.font_size || '18px'};
            line-height: ${metadata.styles?.line_height || '1.6'};
            color: ${metadata.styles?.text_color || '#444444'};
            margin: 0;
            padding: 20px;
            max-width: 800px;
        }

        h1, h2, h3, h4, h5, h6 {
            color: ${metadata.styles?.heading_color || '#333333'};
            margin-top: 30px;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 24px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        h2 {
            font-size: 20px;
            color: #0066cc;
        }

        h3 {
            font-size: 16px;
        }

        p {
            margin-bottom: 15px;
            text-align: justify;
        }

        ul, ol {
            margin-left: 20px;
            margin-bottom: 15px;
        }

        li {
            margin-bottom: 5px;
        }

        code {
            background-color: #f5f5f5;
            padding: 2px 4px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }

        pre {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            margin-bottom: 15px;
        }

        blockquote {
            border-left: 4px solid #0066cc;
            margin-left: 0;
            padding-left: 20px;
            color: #666;
            font-style: italic;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        a {
            color: ${metadata.styles?.link_color || '#0066cc'};
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .page-break {
            page-break-after: always;
        }

        .cover-page {
            text-align: center;
            padding-top: 100px;
            page-break-after: always;
        }

        .cover-page h1 {
            font-size: 36px;
            color: #0066cc;
            border: none;
            page-break-before: auto;
        }

        .cover-page h2 {
            font-size: 24px;
            color: #666;
            margin-bottom: 50px;
        }

        .toc {
            page-break-after: always;
        }

        .toc h1 {
            page-break-before: auto;
        }

        .print-instructions {
            background-color: #e7f3ff;
            border: 1px solid #0066cc;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        @media print {
            .print-instructions { display: none; }
        }
    </style>
</head>
<body>

${htmlContent}

    <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #666; border-top: 1px solid #ddd; padding-top: 20px;">
        <p>Generated on: ${new Date().toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        })}</p>
        <p>${metadata.copyright.notice}</p>
    </div>
</body>
</html>`;

        // Save HTML file
        const htmlPath = path.join(DOCS_DIR, 'User-Manual.html');
        await fs.writeFile(htmlPath, styledHtml, 'utf8');

        console.log('HTML document generated successfully!');
        console.log(`📁 HTML Output: ${htmlPath}`);

        // Try to use wkhtmltopdf if available
        try {
            const { exec } = await import('child_process');
            const { promisify } = await import('util');
            const execAsync = promisify(exec);

            console.log('Attempting to generate PDF using wkhtmltopdf...');

            await execAsync(`wkhtmltopdf --page-size A4 --margin-top 20mm --margin-right 20mm --margin-bottom 20mm --margin-left 20mm "${htmlPath}" "${OUTPUT_PATH}"`);

            console.log('PDF generated successfully using wkhtmltopdf!');
            console.log(`📁 PDF Output: ${OUTPUT_PATH}`);

        } catch (pdfError) {
            console.log('ℹ️  wkhtmltopdf not available, HTML file created instead.');
            console.log('To convert to PDF:');
            console.log('   1. Open the HTML file in a web browser');
            console.log('   2. Use browser\'s "Print to PDF" function');
            console.log('   3. Or install wkhtmltopdf: apt-get install wkhtmltopdf');
        }

        return { htmlPath, pdfPath: OUTPUT_PATH };

    } catch (error) {
        console.error('Error during document generation:', error.message);
        throw error;
    }
}

async function generateStats() {
    try {
        const orderConfig = await loadYamlFile('order.yaml');

        let totalFiles = 0;
        let totalSections = orderConfig.sections.length;

        orderConfig.sections.forEach(section => {
            if (section.file) {
                totalFiles += 1;
            } else if (section.files) {
                totalFiles += section.files.length;
            }
        });

        const htmlPath = path.join(DOCS_DIR, 'User-Manual.html');

        console.log('\nGeneration Statistics:');
        console.log(`   ├── Total Sections: ${totalSections}`);
        console.log(`   ├── Total Files: ${totalFiles + 1}`); // +1 for cover

        try {
            const htmlStats = await fs.stat(htmlPath);
            console.log(`   ├── HTML Size: ${htmlStats.size} bytes`);
        } catch (error) {
            console.log(`   ├── HTML Size: Not generated`);
        }

        try {
            const pdfStats = await fs.stat(OUTPUT_PATH);
            console.log(`   └── PDF Size: ${pdfStats.size} bytes`);
        } catch (error) {
            console.log(`   └── PDF Size: Not generated`);
        }

    } catch (error) {
        console.error(' Could not generate statistics:', error.message);
    }
}

async function main() {
    const startTime = Date.now();

    try {
        // Check if required files exist
        console.log('Checking required files...');
        const requiredFiles = ['order.yaml', 'metadata.yaml', 'cover.md'];

        for (const file of requiredFiles) {
            const exists = await fs.pathExists(path.join(DOCS_DIR, file));
            if (!exists) {
                throw new Error(`Required file missing: ${file}`);
            }
            console.log(`   ${file}`);
        }

        // Generate PDF
        await generatePDF();

        // Generate statistics
        await generateStats();

        const endTime = Date.now();
        const duration = ((endTime - startTime) / 1000).toFixed(2);

        console.log(`\n🎉 User Manual generated successfully in ${duration}s!`);
        console.log(`📄 File: ${OUTPUT_PATH}`);
        console.log(`Command: node docs/generate-user-manual.js`);

    } catch (error) {
        console.error('\n💥 Generation failed:', error.message);
        process.exit(1);
    }
}

// Run the script
if (import.meta.url === `file://${process.argv[1]}`) {
    main();
}

export { generatePDF, combineMarkdownFiles, loadYamlFile, loadMarkdownFile };
