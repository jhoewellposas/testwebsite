document.addEventListener('DOMContentLoaded', function () {
    // Add click event listener for OCR buttons
    const ocrButtons = document.querySelectorAll('.ocr-result-btn');

    ocrButtons.forEach(button => {
        button.addEventListener('click', function () {
            const ocrResult = button.getAttribute('data-ocr');

            // Calculate the center of the screen for the pop-up
            const popupWidth = 600;
            const popupHeight = 400;
            const left = (window.screen.width / 2) - (popupWidth / 2);
            const top = (window.screen.height / 2) - (popupHeight / 2);

            // Create a centered pop-up window
            const popup = window.open(
                '',
                'OCR Result',
                `width=${popupWidth},height=${popupHeight},scrollbars=yes,left=${left},top=${top}`
            );

            if (popup) {
                // Write the OCR result into the pop-up
                popup.document.write(`
                    <html>
                    <head>
                        <title>OCR Result</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                padding: 20px;
                                text-align: center;
                            }
                            pre {
                                text-align: left;
                                background: #f4f4f4;
                                padding: 10px;
                                border-radius: 5px;
                                overflow: auto;
                            }
                            button {
                                margin-top: 20px;
                                padding: 10px 20px;
                                font-size: 16px;
                                cursor: pointer;
                                background-color: #007BFF;
                                color: white;
                                border: none;
                                border-radius: 5px;
                            }
                            button:hover {
                                background-color: #0056b3;
                            }
                        </style>
                    </head>
                    <body>
                        <h2>OCR Output</h2>
                        <pre>${ocrResult}</pre>
                        <button onclick="window.close()">Close</button>
                    </body>
                    </html>
                `);

                popup.document.close();
            } else {
                alert('Please allow pop-ups for this site.');
            }
        });
    });
});