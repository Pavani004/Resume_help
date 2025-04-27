async function analyze() {
    const resumeText = document.getElementById('resume').value.trim();
    const jdText = document.getElementById('jd').value.trim();

    if (!resumeText || !jdText) {
        alert('Please enter both Resume and Job Description.');
        return;
    }

    const formData = new FormData();
    formData.append('resumeText', resumeText);
    formData.append('jdText', jdText);

    try {
        const response = await fetch('http://localhost/resume-analyzer/backend/analyze.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        document.getElementById('result').innerHTML = `
            <b>Score:</b> ${data.score}%<br>
            <b>Matched Keywords:</b> ${data.matchedKeywords.join(", ")}<br>
            <b>Suggestions:</b> ${data.suggestions}
        `;
    } catch (error) {
        console.error('Error analyzing resume:', error);
        alert('Something went wrong while analyzing.');
    }
}

async function draftEmail() {
    const resumeText = document.getElementById('resume').value.trim();
    const jdText = document.getElementById('jd').value.trim();
    const experience = document.getElementById('experience').value.trim();

    if (!resumeText || !jdText || !experience) {
        alert('Please fill Resume, Job Description and Experience.');
        return;
    }

    const formData = new FormData();
    formData.append('resumeText', resumeText);
    formData.append('jdText', jdText);
    formData.append('experience', experience);

    try {
        const response = await fetch('http://localhost/resume-analyzer/backend/emaildraft.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        document.getElementById('emailResult').innerText = data.emailDraft;
    } catch (error) {
        console.error('Error drafting email:', error);
        alert('Something went wrong while drafting email.');
    }
}
