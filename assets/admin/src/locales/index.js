import elementEnLocale from 'element-ui/lib/locale/lang/en' // element-ui lang
import elementZhLocale from 'element-ui/lib/locale/lang/zh-CN'// element-ui lang
import cnLocale from './cn';
import enLocale from './en';

var locale = {
    cn: {
        ...cnLocale,
        ...elementZhLocale
    },
    en: {
        ...enLocale,
        ...elementEnLocale
    }
};

export default locale;


