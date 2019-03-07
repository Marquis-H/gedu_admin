/**
 * @param {Sting} url
 * @param {Sting} title
 * @param {Number} w
 * @param {Number} h
 */

export default function openWindow(url, title, w, h) {
    // Fixes dual-screen position                            Most browsers       Firefox
    // eslint-disable-next-line
    const dualScreenLeft = window.screenLeft !== undefined ? window.screenLeft : screen.left;
    // eslint-disable-next-line
    const dualScreenTop = window.screenTop !== undefined ? window.screenTop : screen.top;

    // eslint-disable-next-line
    const width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    // eslint-disable-next-line
    const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    const left = ((width / 2) - (w / 2)) + dualScreenLeft;
    const top = ((height / 2) - (h / 2)) + dualScreenTop;
    // eslint-disable-next-line
    const newWindow = window.open(url, title, `toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, copyhistory=no, width=${w}, height=${h}, top=${top}, left=${left}`);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}
