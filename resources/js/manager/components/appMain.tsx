import AppMainSideBar from "@manager/components/appMainSideBar";

export default function ({ children } : { children: any }) {
    return (
        <main style={{ padding: 0 }}>
            <div className="table" style={{ minHeight: '1000px' }}>
                <div className="tr">
                    <AppMainSideBar/>
                    <div className="td">
                        <div style={{ padding: '20px' }}>
                            { children }
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
}
