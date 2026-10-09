// languages.js — i18n for Asto: Kurdish (ku, default), English (en), Arabic (ar).
// Markup convention: <span data-i18n="key">Kurdish fallback</span>
// Every key used in a view must exist in ALL three blocks below.

const STORAGE_KEY = 'asto_lang';

const LANGS = {
  ku: { label: 'کوردی',   dir: 'rtl', html: 'ckb' },
  en: { label: 'English', dir: 'ltr', html: 'en'  },
  ar: { label: 'العربية', dir: 'rtl', html: 'ar'  },
};

const translations = {
  ku: {
    db_title: 'بنکەی زانیاری',
    area_finance: 'دارایی',
    area_law: 'یاسا',
    area_library: 'کتێبخانە',
    area_registration: 'تۆمارگە',
    col_name: 'ناو',
    col_id: 'ژمارە',
    col_college: 'کۆلێژ',
    col_department: 'بەش',
    col_stage: 'قۆناغ',
    col_gender: 'ڕەگەز',
    col_email: 'ئیمەیل',
    col_phone: 'مۆبایل',
    col_parallel: 'پاراڵێل',
    gender_male: 'نێر',
    gender_female: 'مێ',
    gender_unspecified: 'دیارینەکراو',
    yes: 'بەڵێ',
    no: 'نەخێر',
    students_empty: 'هیچ خوێندکارێک نەدۆزرایەوە.',
    lang_label: 'زمان',
    logout: 'چوونەدەرەوە',
    login_title: 'چوونەژوورەوە',
    login_username: 'ناوی بەکارهێنەر',
    login_password: 'وشەی نهێنی',
    login_submit: 'چوونەژوورەوە',
    login_error: 'ناوی بەکارهێنەر یان وشەی نهێنی هەڵەیە.',
    lib_col_book: 'کتێب',
    lib_col_borrowed: 'بەرواری وەرگرتن',
    lib_col_returned: 'بەرواری گەڕاندنەوە',
    lib_not_returned: 'هێشتا نەگەڕاوەتەوە',
    lib_empty: 'هیچ کتێبێک وەرنەگیراوە.',
    reg_col_registered: 'بەرواری تۆمارکردن',
  },
  en: {
    db_title: 'Database',
    area_finance: 'Finance',
    area_law: 'Law',
    area_library: 'Library',
    area_registration: 'Registration',
    col_name: 'Name',
    col_id: 'ID',
    col_college: 'College',
    col_department: 'Department',
    col_stage: 'Stage',
    col_gender: 'Gender',
    col_email: 'Email',
    col_phone: 'Phone',
    col_parallel: 'Parallel',
    gender_male: 'Male',
    gender_female: 'Female',
    gender_unspecified: 'Not specified',
    yes: 'Yes',
    no: 'No',
    students_empty: 'No students found.',
    lang_label: 'Language',
    logout: 'Log out',
    login_title: 'Log in',
    login_username: 'Username',
    login_password: 'Password',
    login_submit: 'Log in',
    login_error: 'Wrong username or password.',
    lib_col_book: 'Book',
    lib_col_borrowed: 'Borrowed on',
    lib_col_returned: 'Returned on',
    lib_not_returned: 'Not returned yet',
    lib_empty: 'No borrowed books yet.',
    reg_col_registered: 'Registered on',
  },
  ar: {
    db_title: 'قاعدة البيانات',
    area_finance: 'المالية',
    area_law: 'القانون',
    area_library: 'المكتبة',
    area_registration: 'التسجيل',
    col_name: 'الاسم',
    col_id: 'الرقم',
    col_college: 'الكلية',
    col_department: 'القسم',
    col_stage: 'المرحلة',
    col_gender: 'الجنس',
    col_email: 'البريد الإلكتروني',
    col_phone: 'الهاتف',
    col_parallel: 'الموازي',
    gender_male: 'ذكر',
    gender_female: 'أنثى',
    gender_unspecified: 'غير محدد',
    yes: 'نعم',
    no: 'لا',
    students_empty: 'لم يتم العثور على طلاب.',
    lang_label: 'اللغة',
    logout: 'تسجيل الخروج',
    login_title: 'تسجيل الدخول',
    login_username: 'اسم المستخدم',
    login_password: 'كلمة المرور',
    login_submit: 'تسجيل الدخول',
    login_error: 'اسم المستخدم أو كلمة المرور غير صحيحة.',
    lib_col_book: 'الكتاب',
    lib_col_borrowed: 'تاريخ الاستعارة',
    lib_col_returned: 'تاريخ الإرجاع',
    lib_not_returned: 'لم يُرجَع بعد',
    lib_empty: 'لا توجد كتب مستعارة بعد.',
    reg_col_registered: 'تاريخ التسجيل',
  },
};

let currentLang = 'ku';
try {
  const saved = localStorage.getItem(STORAGE_KEY);
  if (saved && LANGS[saved]) currentLang = saved;
} catch (e) { /* storage unavailable: stay on Kurdish */ }

// A missing key falls back to Kurdish, then to the raw key (visible on purpose, so it gets noticed).
function t(key) {
  const value = translations[currentLang]?.[key] ?? translations.ku[key];
  if (value === undefined) {
    console.warn('[i18n] missing key:', key);
    return key;
  }
  return value;
}

function applyTranslations() {
  document.querySelectorAll('[data-i18n]').forEach((el) => {
    const value = t(el.dataset.i18n);
    if (el.matches('input, textarea')) {
      el.placeholder = value;
    } else {
      el.textContent = value;
    }
  });
}

function setLanguage(lang) {
  if (!LANGS[lang]) return;
  currentLang = lang;
  try { localStorage.setItem(STORAGE_KEY, lang); } catch (e) { /* ignore */ }

  const root = document.documentElement;
  root.lang = LANGS[lang].html;
  root.dir = LANGS[lang].dir;

  applyTranslations();
  document.dispatchEvent(new CustomEvent('asto:languagechange', { detail: { lang } }));
}

function getLanguage() {
  return currentLang;
}

// Scripts load at the end of <body>, so the DOM is ready.
setLanguage(currentLang);
