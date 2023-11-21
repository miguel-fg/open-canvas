document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("main-canvas");
    const ctx = canvas.getContext("2d");
    const clearBtn = document.getElementById("clear");

    let tool = null;

    ctx.lineWidth = 5;
    ctx.lineCap = "round";

    let isDrawing = false;

    function setColour(colour) {
        ctx.strokeStyle = colour;
    }

    function paintCanvas(colour){
        ctx.fillStyle = colour;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    }

    function getTool() {
        if (document.getElementById("brush").checked === true) {
            tool = "brush";
        } else if (document.getElementById("eraser").checked === true) {
            tool = "eraser";
        } else if (document.getElementById("bucket").checked === true) {
            tool = "bucket";
        }
    }

    function startDrawing(e) {
        isDrawing = true;
        getTool();

        if (tool === "brush") {
            setColour("blue");
        } else if (tool === "eraser") {
            setColour("#F5F5F5");
        } else if (tool === "bucket"){
            paintCanvas("blue");
        } else if (tool === "clear"){
            paintCanvas("#F5F5F5");
        }

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
        if (!isDrawing || !tool) return;

        let { x, y } = getMousePosition(canvas, e);

        ctx.lineTo(x, y);
        ctx.stroke();
    }

    canvas.addEventListener("mousemove", (e) => draw(e));
    canvas.addEventListener("mousedown", (e) => startDrawing(e));
    canvas.addEventListener("mouseup", (e) => endDrawing(e));
    canvas.addEventListener("mouseout", (e) => endDrawing(e));
    clearBtn.addEventListener("click", (e) => paintCanvas("#F5F5F5"));
});
