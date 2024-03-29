export default function createUniqueString() {
    const timestamp = `${+new Date()}`;
    const randomNum = `${parseInt((1 + Math.random()) * 65536, 10)}`;
    return (+(randomNum + timestamp)).toString(32);
}
