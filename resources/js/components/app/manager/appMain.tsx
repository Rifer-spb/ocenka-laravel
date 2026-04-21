import AppMainSideBar from "@/components/app/manager/appMainSideBar";

export default function ({ children } : { children: any }) {
    return (
        <main style={{ padding: 0 }}>
            <div className="table">
                <div className="tr">
                    <AppMainSideBar/>
                    <div className="td">
                        <div className="page">
                            <div className="content">
                                {children}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    );
}
