function toggleZoom(imgElement) {
    // 检查图片是否已经被放大
    if (imgElement.classList.contains("zoomed")) {
        // 如果已经放大，移除放大效果
        imgElement.classList.remove("zoomed");
    } else {
        // 移除其他图片的放大效果
        document.querySelectorAll(".col-3 img").forEach(img => {
            img.classList.remove("zoomed");
        });
        // 为当前点击的图片添加放大效果
        imgElement.classList.add("zoomed");
    }
}
