export default function (currentPage, totalPages, delta = 2) {
    let range = [], rangeWithDots = [];

    range.push(1);

    if (totalPages <= 1){
        return range;
    }

    for (let i = currentPage - delta; i <= currentPage + delta; i++) {
        if (1 < i && i < totalPages) {
            range.push(i);
        }
    }

    range.push(totalPages);

    let prev = 0;

    range.forEach(item => {
        if (item !== 1) {
            if (item - prev === 2) {
                rangeWithDots.push(prev + 1);
            } else if (item - prev !== 1) {
                rangeWithDots.push('...');
            }
        }

        rangeWithDots.push(item);
        prev = item;
    });

    return rangeWithDots;
}
