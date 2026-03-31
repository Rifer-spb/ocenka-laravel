import AppHeader from '@/components/app/app-header';

export default ({ children } : {children:any}) => (
    <div className="layout">
        <AppHeader/>
        <main>
            { children }
        </main>
    </div>
);
