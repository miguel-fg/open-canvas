document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("main-canvas");
    const ctx = canvas.getContext("2d");

    ctx.lineWidth = 5;
    ctx.lineCap = "round";

    let isDrawing = false;

    function startDrawing(e) {
        isDrawing = true;
        ctx.beginPath();
        draw(e);
    }

    function endDrawing(e) {
        isDrawing = false;
    }

    function getMousePosition(canvas, event) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;

        return {
            x: (event.clientX - rect.left) * scaleX,
            y: (event.clientY - rect.top) * scaleY,
        };
    }

    function draw(e) {
        if (!isDrawing) return;

        let { x, y } = getMousePosition(canvas, e);

        ctx.lineTo(x, y);
        ctx.stroke();
    }

    canvas.addEventListener("mousemove", (e) => draw(e));
    canvas.addEventListener("mousedown", (e) => startDrawing(e));
    canvas.addEventListener("mouseup", (e) => endDrawing(e));
    canvas.addEventListener("mouseout", (e) => endDrawing(e));
});
